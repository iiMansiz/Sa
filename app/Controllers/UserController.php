<?php
namespace App\Controllers;

class UserController {
    public function profile() {
        echo "Halaman Profil Pengguna.";
        // Tampilkan informasi profil pengguna yang login
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            // Logika untuk memperbarui informasi profil pengguna yang login
            echo "Memperbarui profil menjadi: Nama - " . htmlspecialchars($name) . ", Email - " . htmlspecialchars($email);
            header('Location: /user/profile');
            exit;
        } else {
            // Metode bukan POST, redirect kembali ke halaman profil
            header('Location: /user/profile');
            exit;
        }
    }
}
