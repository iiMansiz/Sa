<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Product.php';
require_once 'models/Cart.php';

class CartController extends Controller {
    private $productModel;

    public function __construct() {
        Session::start();
        $this->productModel = $this->model('Product');
    }

    public function index() {
        $cartItems = Cart::getItems();
        $productsInCart = [];
        $totalPrice = 0;

        foreach ($cartItems as $productId => $quantity) {
            $product = $this->productModel->find($productId);
            if ($product) {
                $product['quantity'] = $quantity;
                $productsInCart[] = $product;
                $totalPrice += $product['harga'] * $quantity;
            } else {
                Cart::removeItem($productId); // Hapus jika produk tidak ditemukan
            }
        }

        $this->view('buyer/cart', ['cartItems' => $productsInCart, 'totalPrice' => $totalPrice]);
    }

    public function add($productId) {
        if (!Session::get('user_id')) {
            $this->redirect('/auth/login'); // Harus login dulu
            return;
        }
        Cart::addItem($productId);
        $this->redirect('/cart');
    }

    public function update($productId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantity = (int) $_POST['quantity'];
            if ($quantity > 0) {
                Cart::updateItem($productId, $quantity);
            } else {
                Cart::removeItem($productId);
            }
        }
        $this->redirect('/cart');
    }

    public function remove($productId) {
        Cart::removeItem($productId);
        $this->redirect('/cart');
    }

    public function clear() {
        Cart::clear();
        $this->redirect('/cart');
    }
}
?>
