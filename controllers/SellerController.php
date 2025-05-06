<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Product.php';
require_once 'models/Order.php';
require_once 'models/Category.php';

require_once 'models/SellerRating.php';

class SellerController extends Controller {
    private $productModel;
    private $orderModel;
    private $categoryModel;
    private $sellerRatingModel;

    public function __construct() {
        // ... (constructor sebelumnya)
        $this->sellerRatingModel = $this->model('SellerRating');
    }

    public function dashboard() {
        $userId = Session::get('user_id');
        $totalProducts = count($this->productModel->getProductsBySeller($userId));
        $orders = $this->orderModel->getOrdersByUser($userId, 'seller');
        $averageRating = $this->sellerRatingModel->getAverageRating($userId);
        $this->view('seller/dashboard', ['total_products' => $totalProducts, 'total_orders' => count($orders), 'average_rating' => $averageRating]);
    }

    // ... (metode lain)
}
?>
