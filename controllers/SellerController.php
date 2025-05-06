<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Product.php';
require_once 'models/Order.php';
require_once 'models/Category.php';

class SellerController extends Controller {
    private $productModel;
    private $orderModel;
    private $categoryModel;

    public function __construct() {
        Session::start();
        if (Session::get('user_role') !== 'seller') {
            $this->redirect('/auth/login');
        }
        $this->productModel = $this->model('Product');
        $this->orderModel = $this->model('Order');
        $this->categoryModel = $this->model('Category');
    }

    // ... (metode dashboard dan productList tetap sama)

    public function addProduct() {
        $categories = $this->categoryModel->getAllCategories();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['nama'];
            $deskripsi = $_POST['deskripsi'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];
            $categoryId = $_POST['category_id'];
            $sellerId = Session::get('user_id');

            $data = [
                'nama' => $nama,
                'deskripsi' => $deskripsi,
                'harga' => $harga,
                'stok' => $stok,
                'category_id' => $categoryId,
                'seller_id' => $sellerId,
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->productModel->insert($data)) {
                $this->redirect('/seller/products');
            } else {
                $error = 'Gagal menambahkan produk.';
                $this->view('seller/product/add', ['categories' => $categories, 'error' => $error]);
            }
        } else {
            $this->view('seller/product/add', ['categories' => $categories]);
        }
    }

    public function editProduct($id) {
        $product = $this->productModel->find($id);
        $categories = $this->categoryModel->getAllCategories();
        if (!$product || $product['seller_id'] !== Session::get('user_id')) {
            $this->redirect('/seller/products');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['nama'];
            $deskripsi = $_POST['deskripsi'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];
            $categoryId = $_POST['category_id'];

            $data = [
                'nama' => $nama,
                'deskripsi' => $deskripsi,
                'harga' => $harga,
                'stok' => $stok,
                'category_id' => $categoryId,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->productModel->update($id, $data)) {
                $this->redirect('/seller/products');
            } else {
                $error = 'Gagal menyimpan perubahan.';
                $this->view('seller/product/edit', ['product' => $product, 'categories' => $categories, 'error' => $error]);
            }
        } else {
            $this->view('seller/product/edit', ['product' => $product, 'categories' => $categories]);
        }
    }

    // ... (metode orderList tetap sama)
}
?>
