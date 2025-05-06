<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Order.php';
require_once 'models/OrderItem.php';

class OrderController extends Controller {
    private $orderModel;
    private $orderItemModel;

    public function __construct() {
        Session::start();
        if (!Session::get('user_id')) {
            $this->redirect('/auth/login');
        }
        $this->orderModel = $this->model('Order');
        $this->orderItemModel = $this->model('OrderItem');
    }

    public function index() {
        $userId = Session::get('user_id');
        $orders = $this->orderModel->getOrdersByUser($userId, 'buyer');
        $this->view('buyer/order_history', ['orders' => $orders]);
    }

    public function detail($orderId) {
        $userId = Session::get('user_id');
        $order = $this->orderModel->find($orderId);

        if ($order && $order['buyer_id'] == $userId) {
            $orderItems = $this->orderItemModel->getItemsByOrder($orderId);
            $this->view('buyer/order_detail', ['order' => $order, 'orderItems' => $orderItems]);
        } else {
            // Handle jika pesanan tidak ditemukan atau bukan milik pembeli
            $this->redirect('/orders');
        }
    }
}
?>
