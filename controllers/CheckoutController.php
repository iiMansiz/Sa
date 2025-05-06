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

class CheckoutController extends Controller {
    private $orderModel;
    private $orderItemModel;
    private $productModel;
    private $promotionModel;
    private $shippingMethodModel;

    public function __construct() {
        // ... (constructor sebelumnya)
        $this->promotionModel = $this->model('Promotion');
        $this->shippingMethodModel = $this->model('ShippingMethod');
    }

    public function index() {
        $cartItems = Cart::getItems();
        $productsInCart = [];
        $totalPrice = 0;

        foreach ($cartItems as $productId => $quantity) {
            $product = $this->productModel->find($productId);
            if ($product) {
                $product['quantity'] = $quantity;
                $promotions = $this->promotionModel->getPromotionsForProduct($productId);
                $product['promotions'] = $promotions; // Attach promotions to product
                $productsInCart[] = $product;
                $totalPrice += $product['harga'] * $quantity;
            } else {
                Cart::removeItem($productId);
            }
        }

        $shippingMethods = $this->shippingMethodModel->getActiveShippingMethods();
        $this->view('buyer/checkout', ['cartItems' => $productsInCart, 'totalPrice' => $totalPrice, 'shippingMethods' => $shippingMethods]);
    }

    public function processOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // ... (proses order sebelumnya)

            $shippingMethodId = $_POST['shipping_method'] ?? null;
            $shippingCost = 0;
            if ($shippingMethodId) {
                $shippingMethod = $this->shippingMethodModel->find($shippingMethodId);
                if ($shippingMethod && $shippingMethod['status']) {
                    $shippingCost = $shippingMethod['biaya'];
                }
            }

            // Aplikasikan promosi di sini sebelum menyimpan order
            $discountAmount = 0;
            // Logic untuk menerapkan promosi berdasarkan kode atau otomatis

            $finalTotalAmount = $totalAmount + $shippingCost - $discountAmount;

            $orderData = [
                'buyer_id' => $userId,
                'total_amount' => $finalTotalAmount,
                'shipping_cost' => $shippingCost,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $orderId = $this->orderModel->insert($orderData);

            // ... (simpan order items seperti sebelumnya)

            if ($orderSuccess) {
                $this->orderModel->update($orderId, ['total_amount' => $finalTotalAmount, 'shipping_cost' => $shippingCost]);
                Cart::clear();
                $this->redirect('/payment/' . $orderId);
            }
        } else {
            $this->redirect('/checkout');
        }
    }
}
?>

