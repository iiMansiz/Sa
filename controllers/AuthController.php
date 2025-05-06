<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/User.php';

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        Session::start();
        $this->userModel = $this->model('User');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                Session::set('user_id', $user['id']);
                Session::set('user_role', $user['role']); // 'buyer', 'seller', 'admin'
                $this->redirect('/' . $user['role'] . '/dashboard');
            } else {
                $error = 'Email atau password salah.';
                $this->view('auth/login', ['error' => $error]);
            }
        } else {
            $this->view('auth/login');
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $role = 'buyer'; // Default role saat registrasi

            // Validasi dan simpan ke database
            if ($this->userModel->insert(['nama' => $nama, 'email' => $email, 'password' => $password, 'role' => $role])) {
                $this->redirect('/auth/login');
            } else {
                $error = 'Gagal mendaftar.';
                $this->view('auth/register', ['error' => $error]);
            }
        } else {
            $this->view('auth/register');
        }
    }

    public function logout() {
        Session::destroy();
        $this->redirect('/auth/login');
    }
}
?>
