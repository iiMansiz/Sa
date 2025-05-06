<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Product.php';

class HomeController extends Controller {
    private $productModel;

    public function __construct() {
        Session::start();
        // Otentikasi pembeli bisa ditambahkan di sini jika perlu akses khusus
        $this->productModel = $this->model('Product');
    }

    public function index() {
        $products = $this->productModel->all();
        $this->view('buyer/home', ['products' => $products]);
    }
}
?>
