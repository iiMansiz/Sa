<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Order.php';
require_once 'models/OrderItem.php';
require_once 'models/Product.php'; // Untuk mendapatkan nama produk

class OrderController extends Controller {
    private $orderModel;
    private $orderItemModel;
    private $productModel;

    public function __construct() {
        Session::start();
        $this->orderModel = $this->model('Order');
        $this->orderItemModel = $this->model('OrderItem');
        $this->productModel = $this->model('Product');
    }

    // Untuk pembeli
    public function index() {
        $userId = Session::get('user_id');
        $orders = $this->orderModel->getOrdersByUser($userId, 'buyer');
        $this->view('buyer/order_history', ['orders' => $orders]);
    }

    // Untuk pembeli
    public function detail($orderId) {
        $userId = Session::get('user_id');
        $order = $this->orderModel->find($orderId);

        if ($order && $order['buyer_id'] == $userId) {
            $orderItems = $this->orderItemModel->getItemsByOrder($orderId);
            $this->view('buyer/order_detail', ['order' => $order, 'orderItems' => $orderItems]);
        } else {
            $this->redirect('/orders');
        }
    }

    // Untuk penjual
    public function sellerOrderList() {
        if (Session::get('user_role') !== 'seller') {
            $this->redirect('/dashboard'); // Atau halaman error
            return;
        }
        $userId = Session::get('user_id');
        // Ambil semua pesanan yang mengandung produk dari penjual ini
        $sql = "SELECT o.* FROM orders o
                JOIN order_items oi ON o.id = oi.order_id
                JOIN products p ON oi.product_id = p.id
                WHERE p.seller_id = " . (int) $userId . "
                GROUP BY o.id
                ORDER BY o.created_at DESC";
        $result = $this->orderModel->query($sql);
        $orders = $this->orderModel->fetchAll($result);
        $this->view('seller/order/list', ['orders' => $orders]);
    }

    // Untuk penjual melihat detail pesanan
    public function sellerOrderDetail($orderId) {
        if (Session::get('user_role') !== 'seller') {
            $this->redirect('/dashboard'); // Atau halaman error
            return;
        }
        $userId = Session::get('user_id');
        $order = $this->orderModel->find($orderId);
        if (!$order) {
            $this->redirect('/seller/orders');
            return;
        }

        // Pastikan pesanan ini mengandung produk dari penjual ini
        $sql = "SELECT oi.*, p.nama AS product_name, p.harga AS product_price
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = " . (int) $orderId . " AND p.seller_id = " . (int) $userId;
        $result = $this->orderModel->query($sql);
        $orderItems = $this->orderModel->fetchAll($result);

        if ($orderItems) {
            $this->view('seller/order/detail', ['order' => $order, 'orderItems' => $orderItems]);
        } else {
            $this->redirect('/seller/orders'); // Tidak ada item dari penjual ini di pesanan ini
        }
    }

    // Untuk admin (bisa melihat semua detail pesanan)
    public function adminOrderDetail($orderId) {
        if (Session::get('user_role') !== 'admin') {
            $this->redirect('/admin/dashboard'); // Atau halaman error
            return;
        }
        $order = $this->orderModel->find($orderId);
        if ($order) {
            $orderItems = $this->orderItemModel->getItemsByOrder($orderId);
            $this->view('admin/order/detail', ['order' => $order, 'orderItems' => $orderItems]);
        } else {
            $this->redirect('/admin/orders');
        }
    }

    // Metode untuk update status pesanan (admin/seller)
    public function updateOrderStatus($orderId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && (Session::get('user_role') === 'admin' || Session::get('user_role') === 'seller')) {
            $newStatus = $_POST['status'];
            // Tambahkan validasi status yang diperbolehkan
            $this->orderModel->update($orderId, ['status' => $newStatus]);
            $this->redirect($_SERVER['HTTP_REFERER']); // Kembali ke halaman sebelumnya
        } else {
            $this->redirect('/dashboard'); // Atau halaman error
        }
    }
}
?>
