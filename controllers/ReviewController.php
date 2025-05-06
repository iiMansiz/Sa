<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Review.php';

class ReviewController extends Controller {
    private $reviewModel;

    public function __construct() {
        Session::start();
        if (!Session::get('user_id')) {
            $this->redirect('/auth/login');
        }
        $this->reviewModel = $this->model('Review');
    }

    public function add($productId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rating = $_POST['rating'];
            $komentar = $_POST['komentar'];
            $userId = Session::get('user_id');

            $data = [
                'product_id' => $productId,
                'user_id' => $userId,
                'rating' => $rating,
                'komentar' => $komentar
            ];

            if ($this->reviewModel->addReview($data)) {
                Session::set('success_message', 'Terima kasih atas ulasan Anda!');
            } else {
                Session::set('error_message', 'Gagal menambahkan ulasan.');
            }
            $this->redirect('/product/' . $productId);
        } else {
            $this->redirect('/product/' . $productId);
        }
    }
}
?>
