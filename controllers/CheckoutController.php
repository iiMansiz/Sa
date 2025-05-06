<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Cart.php';
require_once 'models/Order.php';
require_once 'models/OrderItem.php';
require_once 'models/Product.php'; // Untuk update stok

class CheckoutController extends Controller {
    private $orderModel;
    private $orderItemModel;
    private $productModel;

    public function __construct() {
        Session::start();
        if (!Session::get('user_id')) {
            $this->redirect('/auth/login');
        }
        $this->orderModel = $this->model('Order');
        $this->orderItemModel = $this->model('OrderItem');
        $this->productModel = $this->model('Product');
    }

    public function index() {
        $cartItems = Cart::getItems();
        $productsInCart = [];
        $totalPrice = 0;

        foreach ($cartItems as $productId => $quantity) {
            $product = $this->productModel->find($productId);
            if ($product) {
                $product['quantity'] = $quantity;
                $productsInCart[] = $product;
                $totalPrice += $product['harga'] * $quantity;
            } else {
                Cart::removeItem($productId); // Hapus jika produk tidak ditemukan
            }
        }

        $this->view('buyer/checkout', ['cartItems' => $productsInCart, 'totalPrice' => $totalPrice]);
    }

    public function processOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = Session::get('user_id');
            $cartItems = Cart::getItems();

            if (empty($cartItems)) {
                $this->redirect('/cart');
                return;
            }

            // Simpan data pesanan ke tabel 'orders'
            $orderData = [
                'buyer_id' => $userId,
                'total_amount' => 0, // Akan dihitung
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $orderId = $this->orderModel->insert($orderData);

            $totalAmount = 0;
            foreach ($cartItems as $productId => $quantity) {
                $product = $this->productModel->find($productId);
                if ($product && $product['stok'] >= $quantity) {
                    // Simpan item pesanan ke tabel 'order_items'
                    $orderItemData = [
                        'order_id' => $orderId,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'price_per_item' => $product['harga']
                    ];
                    $this->orderItemModel->insert($orderItemData);
                    $totalAmount += $product['harga'] * $quantity;

                    // Update stok produk
                    $newStok = $product['stok'] - $quantity;
                    $this->productModel->update($productId, ['stok' => $newStok]);
                } else {
                    // Batalkan pesanan atau berikan notifikasi kesalahan (implementasi lebih lanjut)
                    $this->orderModel->delete($orderId);
                    Cart::clear();
                    Session::set('error_message', 'Beberapa produk tidak tersedia atau stok tidak mencukupi.');
                    $this->redirect('/cart');
                    return;
                }
            }

            // Update total amount pesanan
            $this->orderModel->update($orderId, ['total_amount' => $totalAmount]);

            // Bersihkan keranjang setelah pesanan berhasil
            Cart::clear();
            Session::set('success_message', 'Pesanan Anda berhasil dibuat dengan nomor: ' . $orderId);
            $this->redirect('/orders'); // Redirect ke riwayat pesanan
        } else {
            $this->redirect('/checkout');
        }
    }
}
?>
