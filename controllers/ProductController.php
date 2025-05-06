<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Product.php';

class ProductController extends Controller {
    private $productModel;

    public function __construct() {
        Session::start();
        // Otentikasi pembeli bisa ditambahkan di sini jika perlu akses khusus
        $this->productModel = $this->model('Product');
    }

    public function detail($id) {
        $product = $this->productModel->find($id);
        if ($product) {
            $this->view('buyer/product_detail', ['product' => $product]);
        } else {
            // Handle produk tidak ditemukan
            $this->view('errors/404');
        }
    }
}
?>
