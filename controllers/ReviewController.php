<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Review.php';
require_once 'models/SellerRating.php';
require_once 'models/Order.php';

class ReviewController extends Controller {
    private $reviewModel;
    private $sellerRatingModel;
    private $orderModel;

    public function __construct() {
        // ... (constructor sebelumnya)
        $this->sellerRatingModel = $this->model('SellerRating');
        $this->orderModel = $this->model('Order');
    }

    // ... (metode add untuk ulasan produk)

    public function rateSeller($sellerId, $orderId) {
        if (!Session::get('user_id')) {
            $this->redirect('/auth/login');
            return;
        }
        $buyerId = Session::get('user_id');

        // Pastikan pembeli ini yang melakukan order dengan penjual ini
        $order = $this->orderModel->find($orderId);
        if (!$order || $order['buyer_id'] != $buyerId) {
            $this->redirect('/orders'); // Atau halaman error
            return;
        }

        // Periksa apakah pembeli sudah memberikan rating untuk penjual ini
        if ($this->sellerRatingModel->checkUserRated($sellerId, $buyerId)) {
            Session::set('error_message', 'Anda sudah memberikan rating untuk penjual ini.');
            $this->redirect('/orders/' . $orderId);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rating = $_POST['rating'];
            $komentar = $_POST['komentar'];

            $data = [
                'seller_id' => $sellerId,
                'user_id' => $buyerId,
                'rating' => $rating,
                'komentar' => $komentar
            ];

            if ($this->sellerRatingModel->addRating($data)) {
                Session::set('success_message', 'Terima kasih atas rating Anda!');
            } else {
                Session::set('error_message', 'Gagal memberikan rating.');
            }
            $this->redirect('/orders/' . $orderId);
        } else {
            // Tampilkan form rating penjual (belum dibuat viewnya)
            $this->view('buyer/rate_seller', ['sellerId' => $sellerId, 'orderId' => $orderId]);
        }
    }
}
?>
