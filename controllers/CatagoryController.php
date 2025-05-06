<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Category.php';

class CategoryController extends Controller {
    private $categoryModel;

    public function __construct() {
        Session::start();
        if (Session::get('user_role') !== 'admin') {
            $this->redirect('/admin/dashboard');
        }
        $this->categoryModel = $this->model('Category');
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        $this->view('admin/category/list', ['categories' => $categories]);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['nama'];
            if ($this->categoryModel->insert(['nama' => $nama])) {
                $this->redirect('/admin/categories');
            } else {
                $error = 'Gagal menambahkan kategori.';
                $this->view('admin/category/add', ['error' => $error]);
            }
        } else {
            $this->view('admin/category/add');
        }
    }

    public function edit($id) {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            $this->redirect('/admin/categories');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['nama'];
            if ($this->categoryModel->update($id, ['nama' => $nama])) {
                $this->redirect('/admin/categories');
            } else {
                $error = 'Gagal menyimpan perubahan.';
                $this->view('admin/category/edit', ['category' => $category, 'error' => $error]);
            }
        } else {
            $this->view('admin/category/edit', ['category' => $category]);
        }
    }

    public function delete($id) {
        if ($this->categoryModel->delete($id)) {
            $this->redirect('/admin/categories');
        } else {
            // Handle error
            echo "Gagal menghapus kategori.";
        }
    }
}
?>
