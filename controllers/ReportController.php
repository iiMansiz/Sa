<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Report.php';
require_once 'models/Order.php';
require_once 'models/Product.php';

class ReportController extends Controller {
    private $reportModel;
    private $orderModel;
    private $productModel;

    public function __construct() {
        Session::start();
        $this->reportModel = $this->model('Report');
        $this->orderModel = $this->model('Order');
        $this->productModel = $this->model('Product');
    }

    // Admin Reports
    public function adminSalesOverview() {
        if (Session::get('user_role') !== 'admin') {
            $this->redirect('/admin/dashboard');
            return;
        }
        // Contoh: Ambil data penjualan harian
        $dailySales = $this->orderModel->getDailySales(); // Perlu implementasi di model Order
        $this->view('admin/report/sales_overview', ['dailySales' => $dailySales]);
    }

    public function adminProductPerformance() {
        if (Session::get('user_role') !== 'admin') {
            $this->redirect('/admin/dashboard');
            return;
        }
        // Contoh: Ambil data produk terlaris
        $topSellingProducts = $this->productModel->getTopSellingProducts(); // Perlu implementasi di model Product
        $this->view('admin/report/product_performance', ['topSellingProducts' => $topSellingProducts]);
    }

    // Seller Reports
    public function sellerSalesOverview() {
        if (Session::get('user_role') !== 'seller') {
            $this->redirect('/seller/dashboard');
            return;
        }
        $sellerId = Session::get('user_id');
        $dailySales = $this->orderModel->getSellerDailySales($sellerId); // Perlu implementasi di model Order
        $this->view('seller/report/sales_overview', ['dailySales' => $dailySales]);
    }

    public function sellerProductPerformance() {
        if (Session::get('user_role') !== 'seller') {
            $this->redirect('/seller/dashboard');
            return;
        }
        $sellerId = Session::get('user_id');
        $topSellingProducts = $this->productModel->getSellerTopSellingProducts($sellerId); // Perlu implementasi di model Product
        $this->view('seller/report/product_performance', ['topSellingProducts' => $topSellingProducts]);
    }

    // ... (metode lain untuk laporan yang berbeda)
}
?>
