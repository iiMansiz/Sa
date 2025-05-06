<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Promotion.php';
require_once 'models/Product.php';
require_once 'models/Voucher.php';

class PromotionController extends Controller {
    private $promotionModel; // Untuk promosi produk (diskon otomatis)
    private $voucherModel;

    public function __construct() {
        Session::start();
        $this->promotionModel = $this->model('Promotion');
        $this->voucherModel = $this->model('Voucher');
    }

    // Admin Voucher Management
    public function adminVouchers() {
        if (Session::get('user_role') !== 'admin') {
            $this->redirect('/admin/dashboard');
            return;
        }
        $vouchers = $this->voucherModel->all();
        $this->view('admin/voucher/list', ['vouchers' => $vouchers]);
    }

    public function adminAddVoucher() {
        if (Session::get('user_role') !== 'admin') {
            $this->redirect('/admin/dashboard');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            if ($this->voucherModel->insert($data)) {
                $this->redirect('/admin/vouchers');
            } else {
                $error = 'Gagal menambahkan voucher.';
                $this->view('admin/voucher/add', ['error' => $error]);
            }
        } else {
            $this->view('admin/voucher/add');
        }
    }

    public function adminEditVoucher($id) {
        // ... (mirip edit promosi, untuk admin)
    }

    public function adminDeleteVoucher($id) {
        // ... (mirip delete promosi, untuk admin)
    }

    // Seller Voucher Management
    public function sellerVouchers() {
        if (Session::get('user_role') !== 'seller') {
            $this->redirect('/seller/dashboard');
            return;
        }
        $vouchers = $this->voucherModel->getSellerVouchers(Session::get('user_id'));
        $this->view('seller/voucher/list', ['vouchers' => $vouchers]);
    }

    public function sellerAddVoucher() {
        if (Session::get('user_role') !== 'seller') {
            $this->redirect('/seller/dashboard');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['seller_id'] = Session::get('user_id');
            if ($this->voucherModel->insert($data)) {
                $this->redirect('/seller/vouchers');
            } else {
                $error = 'Gagal menambahkan voucher.';
                $this->view('seller/voucher/add', ['error' => $error]);
            }
        } else {
            $this->view('seller/voucher/add');
        }
    }

    public function sellerEditVoucher($id) {
        // ... (mirip edit promosi, untuk penjual, pastikan hanya bisa edit voucher sendiri)
    }

    public function sellerDeleteVoucher($id) {
        // ... (mirip delete promosi, untuk penjual, pastikan hanya bisa hapus voucher sendiri)
    }

    // ... (metode lain untuk promosi produk otomatis)
}
?>

