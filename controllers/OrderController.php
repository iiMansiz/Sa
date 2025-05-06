<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Order.php';
require_once 'models/OrderItem.php';
require_once 'models/Product.php'; // Untuk mendapatkan nama produk
// ... (require statements)
require_once 'models/Notification.php';

class OrderController extends Controller {
    private $orderModel;
    private $orderItemModel;
    private $productModel;
    private $notificationModel;

    public function __construct() {
        // ... (constructor sebelumnya)
        $this->notificationModel = $this->model('Notification');
    }

    // ... (metode controller sebelumnya)

    public function updateOrderStatus($orderId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && (Session::get('user_role') === 'admin' || Session::get('user_role') === 'seller')) {
            $newStatus = $_POST['status'];
            $this->orderModel->update($orderId, ['status' => $newStatus]);

            $order = $this->orderModel->find($orderId);
            if ($order) {
                $buyerId = $order['buyer_id'];
                $this->notificationModel->addNotification($buyerId, 'order_status_updated', 'Status pesanan Anda #' . $orderId ' telah diperbarui menjadi: ' . $newStatus);

                // Jika admin mengubah status, notifikasi penjual juga (opsional)
                if (Session::get('user_role') === 'admin') {
                    $orderItems = $this->orderItemModel->getItemsByOrder($orderId);
                    $sellerIds = [];
                    foreach ($orderItems as $item) {
                        $product = $this->productModel->find($item['product_id']);
                        if ($product && !in_array($product['seller_id'], $sellerIds)) {
                            $this->notificationModel->addNotification($product['seller_id'], 'order_status_updated_seller', 'Status pesanan #' . $orderId ' yang berisi produk Anda telah diperbarui menjadi: ' . $newStatus);
                            $sellerIds[] = $product['seller_id'];
                        }
                    }
                }
            }

            $this->redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->redirect('/dashboard');
        }
    }
}
?>
