<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Product.php';
require_once 'models/Cart.php';
require_once 'core/Controller.php';
require_once 'models/Voucher.php';

class ProductController extends Controller {
    // ... (constructor)

    public function detail($id) {
        $product = $this->productModel->find($id);
        $images = $this->productModel->getProductImages($id);
        $variations = $this->productModel->getProductVariations($id);
        $reviews = $this->model('Review')->getReviewsByProduct($id);

        if ($product) {
            $this->view('buyer/product_detail', ['product' => $product, 'images' => $images, 'variations' => $variations, 'reviews' => $reviews]);
        } else {
            $this->view('errors/404');
        }
    }

    // ...
}

class CartController extends Controller {
    private $productModel;
    private $voucherModel;

    public function __construct() {
        Session::start();
        $this->productModel = $this->model('Product');
        $this->voucherModel = $this->model('Voucher');
    }

    public function index() {
        $cartItems = Cart::getItems();
        $productsInCart = [];
        $totalPrice = 0;

        foreach ($cartItems as $itemKey => $quantity) {
            list($productId, $variationId) = explode('_', $itemKey);
            $product = $this->productModel->find($productId);
            if ($product) {
                $product['quantity'] = $quantity;
                // Ambil informasi variasi jika ada
                if ($variationId) {
                    $variation = $this->productModel->find('product_variations', $variationId);
                    $product['variation'] = $variation;
                    $totalPrice += ($variation['harga'] ?? $product['harga']) * $quantity;
                } else {
                    $totalPrice += $product['harga'] * $quantity;
                }
                $productsInCart[] = $product;
            } else {
                Cart::removeItemByKey($itemKey); // Hapus jika produk tidak ditemukan
            }
        }

        $appliedVoucherId = Session::get('applied_voucher_id');
        $voucher = null;
        if ($appliedVoucherId) {
            $voucher = $this->voucherModel->find($appliedVoucherId);
        }

        $this->view('buyer/cart', ['cartItems' => $productsInCart, 'totalPrice' => $totalPrice, 'voucher' => $voucher]);
    }

    public function add($productId) {
        if (!Session::get('user_id')) {
            $this->redirect('/auth/login');
            return;
        }

        $quantity = $_POST['quantity'] ?? 1;
        $variationId = $_POST['variation_id'] ?? null;

        $itemKey = $productId . ($variationId ? '_' . $variationId : '');
        Cart::addItem($itemKey, $quantity);

        $this->redirect('/cart');
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST['quantity'] as $itemKey => $quantity) {
                if ($quantity > 0) {
                    Cart::updateItem($itemKey, $quantity);
                } else {
                    Cart::removeItemByKey($itemKey);
                }
            }
        }
        $this->redirect('/cart');
    }

    public function remove($itemKey) {
        Cart::removeItemByKey($itemKey);
        $this->redirect('/cart');
    }

    public function clear() {
        Cart::clear();
        Session::delete('applied_voucher_id'); // Hapus voucher saat keranjang dikosongkan
        $this->redirect('/cart');
    }

    public function applyVoucher() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $voucherCode = trim($_POST['voucher_code']);
            if (empty($voucherCode)) {
                Session::set('error_message', 'Kode voucher tidak boleh kosong.');
                $this->redirect('/cart');
                return;
            }

            $voucher = $this->voucherModel->getVoucherByCode($voucherCode);
            if ($voucher) {
                $userId = Session::get('user_id');
                if ($voucher['jumlah_tersedia'] !== null && $voucher['jumlah_digunakan'] >= $voucher['jumlah_tersedia']) {
                    Session::set('error_message', 'Voucher sudah habis digunakan.');
                } elseif ($userId && $this->voucherModel->isVoucherClaimed($voucher['id'], $userId)) {
                    Session::set('error_message', 'Anda sudah mengklaim voucher ini sebelumnya.');
                } else {
                    Session::set('applied_voucher_id', $voucher['id']);
                    Session::set('success_message', 'Voucher berhasil diterapkan!');
                }
            } else {
                Session::set('error_message', 'Kode voucher tidak valid atau tidak berlaku.');
            }
        }
        $this->redirect('/cart');
    }

    public function removeVoucher() {
        Session::delete('applied_voucher_id');
        Session::set('success_message', 'Voucher berhasil dihapus.');
        $this->redirect('/cart');
    }
}
?>
