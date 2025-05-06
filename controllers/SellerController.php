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
        $this->view('seller/product/list', ['products' => $products]);
    }

    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['nama'];
            $deskripsi = $_POST['deskripsi'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];
            $sellerId = Session::get('user_id');

            $data = [
                'nama' => $nama,
                'deskripsi' => $deskripsi,
                'harga' => $harga,
                'stok' => $stok,
                'seller_id' => $sellerId,
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->productModel->insert($data)) {
                $this->redirect('/seller/products');
            } else {
                $error = 'Gagal menambahkan produk.';
                $this->view('seller/product/add', ['error' => $error]);
            }
        } else {
            $this->view('seller/product/add');
        }
    }

    public function editProduct($id) {
        $product = $this->productModel->find($id);
        if (!$product || $product['seller_id'] !== Session::get('user_id')) {
            // Handle produk tidak ditemukan atau bukan milik seller
            $this->redirect('/seller/products');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['nama'];
            $deskripsi = $_POST['deskripsi'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];

            $data = [
                'nama' => $nama,
                'deskripsi' => $deskripsi,
                'harga' => $harga,
                'stok' => $stok,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->productModel->update($id, $data)) {
                $this->redirect('/seller/products');
            } else {
                $error = 'Gagal menyimpan perubahan.';
                $this->view('seller/product/edit', ['product' => $product, 'error' => $error]);
            }
        } else {
            $this->view('seller/product/edit', ['product' => $product]);
        }
    }

    public function orderList() {
        $userId = Session::get('user_id');
        $orders = $this->orderModel->getOrdersByUser($userId, 'seller');
        $this->view('seller/order/list', ['orders' => $orders]);
    }

    // ... metode lain untuk seller (misalnya, manajemen pesanan)
}
?>

