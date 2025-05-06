<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Promotion.php';
require_once 'models/Product.php';

class PromotionController extends Controller {
    private $promotionModel;
    private $productModel;

    public function __construct() {
        Session::start();
        if (Session::get('user_role') !== 'admin') {
            $this->redirect('/admin/dashboard');
        }
        $this->promotionModel = $this->model('Promotion');
        $this->productModel = $this->model('Product');
    }

    public function index() {
        $promotions = $this->promotionModel->all();
        $this->view('admin/promotion/list', ['promotions' => $promotions]);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            if ($this->promotionModel->insert($data)) {
                $this->redirect('/admin/promotions');
            } else {
                $error = 'Gagal menambahkan promosi.';
                $this->view('admin/promotion/add', ['error' => $error]);
            }
        } else {
            $this->view('admin/promotion/add');
        }
    }

    public function edit($id) {
        $promotion = $this->promotionModel->find($id);
        if (!$promotion) {
            $this->redirect('/admin/promotions');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            if ($this->promotionModel->update($id, $data)) {
                $this->redirect('/admin/promotions');
            } else {
                $error = 'Gagal menyimpan perubahan.';
                $this->view('admin/promotion/edit', ['promotion' => $promotion, 'error' => $error]);
            }
        } else {
            $this->view('admin/promotion/edit', ['promotion' => $promotion]);
        }
    }

    public function delete($id) {
        if ($this->promotionModel->delete($id)) {
            $this->redirect('/admin/promotions');
        } else {
            echo "Gagal menghapus promosi.";
        }
    }

    public function manageProducts($id) {
        $promotion = $this->promotionModel->find($id);
        $productsInPromotion = $this->promotionModel->getPromotionsForProduct(null, $id); // Need to adjust model for this
        $allProducts = $this->productModel->all();

        if (!$promotion) {
            $this->redirect('/admin/promotions');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['add_product']) && is_array($_POST['add_product'])) {
                foreach ($_POST['add_product'] as $productId) {
                    $this->promotionModel->addProductToPromotion($id, $productId);
                }
            }
            if (isset($_POST['remove_product']) && is_array($_POST['remove_product'])) {
                foreach ($_POST['remove_product'] as $productId) {
                    $this->promotionModel->removeProductFromPromotion($id, $productId);
                }
            }
            $this->redirect('/admin/promotions/manage/' . $id);
        } else {
            $this->view('admin/promotion/manage_products', ['promotion' => $promotion, 'productsInPromotion' => $productsInPromotion, 'allProducts' => $allProducts]);
        }
    }
}
?>
