<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Product.php';
require_once 'models/Order.php';

class SellerController extends Controller {
    private $productModel;
    private $orderModel;

    public function __construct() {
        Session::start();
        // Otentikasi seller
        if (Session::get('user_role') !== 'seller') {
            $this->redirect('/auth/login'); // Atau halaman error akses ditolak
        }
        $this->productModel = $this->model('Product');
        $this->orderModel = $this->model('Order');
    }

    public function dashboard() {
        $userId = Session::get('user_id');
        $totalProducts = count($this->productModel->where('seller_id', $userId));
        $pendingOrders = count($this->orderModel->where('seller_id', $userId, 'status', 'pending'));
        $this->view('seller/dashboard', ['total_products' => $totalProducts, 'pending_orders' => $pendingOrders]);
    }

    public function productList() {
        $userId = Session::get('user_id');
        $products = $this->productModel->where('seller_id', $userId);
        $this->view
