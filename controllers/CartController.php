<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Product.php';
require_once 'models/Cart.php';

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
    // ... (constructor)

    public function add($productId) {
        if (!Session::get('user_id')) {
            $this->redirect('/auth/login');
            return;
        }

        $quantity = $_POST['quantity'] ?? 1;
        $variationId = $_POST['variation_id'] ?? null; // Jika ada variasi

        // Logic untuk menambahkan ke keranjang dengan mempertimbangkan variasi
        $cartKey = 'shopping_cart_' . Session::get('user_id');
        $cart = Session::get($cartKey, []);
        $itemKey = $productId . ($variationId ? '_' . $variationId : '');

        if (isset($cart[$itemKey])) {
            $cart[$itemKey] += $quantity;
        } else {
            $cart[$itemKey] = $quantity;
        }
        Session::set($cartKey, $cart);

        $this->redirect('/cart');
    }

    // ... (metode lain perlu disesuaikan untuk menangani key keranjang dengan variasi)
}

