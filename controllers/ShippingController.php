<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/ShippingMethod.php';

class ShippingController extends Controller {
    private $shippingMethodModel;

    public function __construct() {
        Session::start();
        if (Session::get('user_role') !== 'admin') {
            $this->redirect('/admin/dashboard');
        }
        $this->shippingMethodModel = $this->model('ShippingMethod');
    }

    public function index() {
        $shippingMethods = $this->shippingMethodModel->all();
        $this->view('admin/shipping/list', ['shippingMethods' => $shippingMethods]);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            if ($this->shippingMethodModel->insert($data)) {
                $this->redirect('/admin/shipping');
            } else {
                $error = 'Gagal menambahkan metode pengiriman.';
                $this->view('admin/shipping/add', ['error' => $error]);
            }
        } else {
            $this->view('admin/shipping/add');
        }
    }

    public function edit($id) {
        $shippingMethod = $this->shippingMethodModel->find($id);
        if (!$shippingMethod) {
            $this->redirect('/admin/shipping');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            if ($this->shippingMethodModel->update($id, $data)) {
                $this->redirect('/admin/shipping');
            } else {
                $error = 'Gagal menyimpan perubahan.';
                $this->view('admin/shipping/edit', ['shippingMethod' => $shippingMethod, 'error' => $error]);
            }
        } else {
            $this->view('admin/shipping/edit', ['shippingMethod' => $shippingMethod]);
        }
    }

    public function delete($id) {
        if ($this->shippingMethodModel->delete($id)) {
            $this->redirect('/admin/shipping');
        } else {
            echo "Gagal menghapus metode pengiriman.";
        }
    }
}
?>
