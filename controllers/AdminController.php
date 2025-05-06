<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/User.php';
require_once 'models/Product.php';
require_once 'models/Order.php';

class AdminController extends Controller {
    private $userModel;
    private $productModel;
    private $orderModel;

    public function __construct() {
        Session::start();
        // Otentikasi admin
        if (Session::get('user_role') !== 'admin') {
            $this->redirect('/auth/login'); // Atau halaman error akses ditolak
        }
        $this->userModel = $this->model('User');
        $this->productModel = $this->model('Product');
        $this->orderModel = $this->model('Order');
    }

    public function dashboard() {
        $totalUsers = count($this->userModel->all());
        $totalProducts = count($this->productModel->all());
        $totalOrders = count($this->orderModel->all());
        $this->view('admin/dashboard', ['total_users' => $totalUsers, 'total_products' => $totalProducts, 'total_orders' => $totalOrders]);
    }

    public function userList() {
        $users = $this->userModel->all();
        $this->view('admin/user/list', ['users' => $users]);
    }

    public function productList() {
        $products = $this->productModel->all();
        $this->view('admin/product/list', ['products' => $products]);
    }

    public function orderList() {
        $orders = $this->orderModel->all();
        $this->view('admin/order/list', ['orders' => $orders]);
    }

    // ... metode lain untuk manajemen admin (misalnya, edit user, edit produk, edit pesanan)
}
?>
