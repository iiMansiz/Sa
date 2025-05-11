<?php
namespace App\Controllers;

use Core\Session;

class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Lakukan otentikasi pengguna (periksa database menggunakan model)
            // Contoh sederhana (jangan gunakan ini untuk produksi):
            if ($username === 'user' && $password === 'pass') {
                Session::set('user_id', 123); // Set session pengguna
                header('Location: /'); // Redirect ke halaman utama
                exit;
            } else {
                echo "Login gagal. Coba lagi.";
                // Tampilkan kembali form login dengan pesan error
            }
        } else {
            echo "Halaman Login.";
            // Tampilkan form login
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Lakukan validasi data registrasi
            if ($password === $confirmPassword) {
                // Simpan data pengguna baru ke database (menggunakan model)
                // Setelah berhasil, mungkin redirect ke halaman login atau halaman utama
                echo "Registrasi berhasil. Silakan login.";
            } else {
                echo "Konfirmasi password tidak sesuai.";
                // Tampilkan kembali form registrasi dengan pesan error
            }
        } else {
            echo "Halaman Registrasi.";
            // Tampilkan form registrasi
        }
    }

    public function logout() {
        Session::destroy();
        header('Location: /auth/login'); // Redirect ke halaman login setelah logout
        exit;
    }
}
