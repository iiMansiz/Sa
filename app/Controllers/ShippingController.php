<?php
namespace App\Controllers;

class ShippingController {
    public function index() {
        echo "Halaman Manajemen Pengiriman (Admin).";
        // Ambil dan tampilkan daftar metode pengiriman
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $cost = $_POST['cost'] ?? '';
            // Logika untuk menambahkan metode pengiriman baru
            echo "Menambahkan metode pengiriman: " . htmlspecialchars($name) . " dengan biaya: " . htmlspecialchars($cost);
            header('Location: /admin/shipping');
            exit;
        } else {
            echo "Form untuk Menambah Metode Pengiriman Baru (Admin).";
            // Tampilkan form tambah metode pengiriman
        }
    }

    public function edit($shippingId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $cost = $_POST['cost'] ?? '';
            // Logika untuk memperbarui metode pengiriman dengan ID $shippingId
            echo "Memperbarui metode pengiriman ID " . htmlspecialchars($shippingId) . " menjadi: " . htmlspecialchars($name) . " dengan biaya: " . htmlspecialchars($cost);
            header('Location: /admin/shipping');
            exit;
        } else {
            echo "Form untuk Mengedit Metode Pengiriman ID " . htmlspecialchars($shippingId) . " (Admin).";
            // Tampilkan form edit metode pengiriman dengan data saat ini
        }
    }

    public function delete($shippingId) {
        // Logika untuk menghapus metode pengiriman dengan ID $shippingId
        echo "Menghapus metode pengiriman ID " . htmlspecialchars($shippingId) . ".";
        header('Location: /admin/shipping');
        exit;
    }
}
