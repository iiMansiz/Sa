<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/User.php';

class UserController extends Controller {
    private $userModel;

    public function __construct() {
        Session::start();
        if (!Session::get('user_id')) {
            $this->redirect('/auth/login');
        }
        $this->userModel = $this->model('User');
    }

    public function profile() {
        $userId = Session::get('user_id');
        $user = $this->userModel->find($userId);
        if ($user) {
            $this->view('user/profile', ['user' => $user]);
        } else {
            // Handle user tidak ditemukan
            $this->redirect('/dashboard'); // Redirect ke dashboard sesuai peran
        }
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = Session::get('user_id');
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            // Tambahkan validasi dan logika update lainnya

            $data = [
                'nama' => $nama,
                'email' => $email,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->userModel->update($userId, $data)) {
                Session::set('success_message', 'Profil berhasil diperbarui.');
            } else {
                Session::set('error_message', 'Gagal memperbarui profil.');
            }
            $this->redirect('/user/profile');
        } else {
            $this->redirect('/user/profile');
        }
    }
}
?>
