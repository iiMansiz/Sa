<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Cart.php';
require_once 'models/Order.php';
require_once 'models/OrderItem.php';
require_once 'models/Product.php'; // Untuk update stok

// ... (require statements)
require_once 'models/Promotion.php';
require_once 'models/ShippingMethod.php';
require_once 'models/Voucher.php';

class CheckoutController extends Controller {
    private $orderModel;
    private $orderItemModel;
    private $productModel;
    private $promotionModel;
    private $shippingMethodModel;
    private $voucherModel;

    public function __construct() {
        Session::start();
        if (!Session::get('user_id')) {
            $this->redirect('/auth/login');
        }
        $this->orderModel = $this->model('Order');
        $this->orderItemModel = $this->model('OrderItem');
        $this->productModel = $this->model('Product');
        $this->promotionModel = $this->model('Promotion');
        $this->shippingMethodModel = $this->model('ShippingMethod');
        $this->voucherModel = $this->model('Voucher');
    }

    public function index() {
        $cartItems = Cart::getItems();
        $productsInCart = [];
        $totalPrice = 0;

        foreach ($cartItems as $itemKey => $quantity) {
            list($productId, $variationId) = explode('_', $itemKey);
            $product = $this->productModel->find($productId);
            if ($product) {
                $product['quantity'] = $quantity;
                if ($variationId) {
                    $variation = $this->productModel->find('product_variations', $variationId);
                    $product['variation'] = $variation;
                    $totalPrice += ($variation['harga'] ?? $product['harga']) * $quantity;
                } else {
                    $totalPrice += $product['harga'] * $quantity;
                }
                $productsInCart[] = $product;
            } else {
                Cart::removeItemByKey($itemKey);
            }
        }

        $shippingMethods = $this->shippingMethodModel->getActiveShippingMethods();
        $appliedVoucherId = Session::get('applied_voucher_id');
        $voucher = null;
        if ($appliedVoucherId) {
            $voucher = $this->voucherModel->find($appliedVoucherId);
        }

        $this->view('buyer/checkout', ['cartItems' => $productsInCart, 'totalPrice' => $totalPrice, 'shippingMethods' => $shippingMethods, 'voucher' => $voucher]);
    }

    public function processOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = Session::get('user_id');
            $cartItems = Cart::getItems();

            if (empty($cartItems)) {
                $this->redirect('/cart');
                return;
            }

            $shippingMethodId = $_POST['shipping_method'] ?? null;
            $shippingCost = 0;
            if ($shippingMethodId) {
                $shippingMethod = $this->shippingMethodModel->find($shippingMethodId);
                if ($shippingMethod && $shippingMethod['status']) {
                    $shippingCost = $shippingMethod['biaya'];
                }
            }

            $totalProductPrice = 0;
            $productsToOrder = [];
            foreach ($cartItems as $itemKey => $quantity) {
                list($productId, $variationId) = explode('_', $itemKey);
                $product = $this->productModel->find($productId);
                if ($product) {
                    $price = $product['harga'];
                    if ($variationId) {
                        $variation = $this->productModel->find('product_variations', $variationId);
                        if ($variation) {
                            $price = $variation['harga'];
                        }
                    }
                    $totalProductPrice += $price * $quantity;
                    $productsToOrder[] = ['product' => $product, 'quantity' => $quantity, 'variation_id' => $variationId, 'price' => $price];
                }
            }

            $voucherDiscount = 0;
            $appliedVoucherId = Session::get('applied_voucher_id');
            if ($appliedVoucherId) {
                $voucher = $this->voucherModel->find($appliedVoucherId);
                if ($voucher) {
                    if ($voucher['minimum_pembelian'] === null || $totalProductPrice >= $voucher['minimum_pembelian']) {
                        if ($voucher['jenis'] === 'diskon_persen') {
                            $voucherDiscount = $totalProductPrice * ($voucher['nilai'] / 100);
                            if ($voucher['maksimum_diskon'] !== null && $voucherDiscount > $voucher['maksimum_diskon']) {
                                $voucherDiscount = $voucher['maksimum_diskon'];
                            }
                        } elseif ($voucher['jenis'] === 'diskon_nominal') {
                            $voucherDiscount = $voucher['nilai'];
                        } elseif ($voucher['jenis'] === 'gratis_ongkir') {
                            $shippingCost = 0;
                        }

                        // Increment penggunaan voucher
                        $this->voucherModel->incrementUsage($voucher['id']);
                    }
                }
                Session::delete('applied_voucher_id'); // Hapus dari sesi setelah digunakan
            }

            $finalTotalAmount = $totalProductPrice + $shippingCost - $voucherDiscount;

            // Simpan data pesanan ke tabel 'orders'
            $orderData = [
                'buyer_id' => $userId,
                'total_amount' => $finalTotalAmount,
                'shipping_cost' => $shippingCost,
                'voucher_discount' => $voucherDiscount,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $orderId = $this->orderModel->insert($orderData);

            $orderSuccess = true;
            foreach ($productsToOrder as $item) {
                $product = $item['product'];
                $quantity = $item['quantity'];
                $variationId = $item['variation_id'];
                $pricePerItem = $item['price'];

                // Cek stok (perlu penanganan stok variasi juga)
                $currentStock = $product['stok'];
                if ($variationId) {
                    $variation = $this->productModel->find('product_variations', $variationId);
                    if ($variation) {
                        $currentStock = $variation['stok'];
                    }
                }

                if ($currentStock >= $quantity) {
                    $orderItemData = [
                        'order_id' => $orderId,
                        'product_id' => $product['id'],
                        'quantity' => $quantity,
                        'price_per_item' => $pricePerItem,
                        'variation_id' => $variationId
                    ];
                    $this->orderItemModel->insert($orderItemData);

                    // Update stok
                    if ($variationId) {
                        $this->productModel->query("UPDATE product_variations SET stok = stok - " . (int) $quantity . " WHERE id = " . (int) $variationId);
                    } else {
                        $this->productModel->update($product['id'], ['stok' => $product['stok'] - $quantity]);
                    }
                } else {
                    $this->orderModel->delete($orderId);
                    Cart::clear();
                    Session::set('error_message', 'Stok beberapa produk tidak mencukupi.');
                    $this->redirect('/cart');
                    $orderSuccess = false;
                    break;
                }
            }

            if ($orderSuccess) {
                Cart::clear();
                $this->redirect('/payment/' . $orderId);
            }
        } else {
            $this->redirect('/checkout');
        }
    }
}
?>
