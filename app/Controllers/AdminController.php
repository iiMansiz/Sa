<?php
namespace App\Controllers;

class AdminController {
    public function dashboard() {
        echo "Halaman Dashboard Admin.";
        // Tampilkan statistik dan informasi penting untuk admin
    }

    public function userList() {
        echo "Halaman Daftar Pengguna (Admin).";
        // Ambil dan tampilkan daftar semua pengguna
    }

    public function productList() {
        echo "Halaman Daftar Produk (Admin).";
        // Ambil dan tampilkan daftar semua produk
    }

    public function orderList() {
        echo "Halaman Daftar Pesanan (Admin).";
        // Ambil dan tampilkan daftar semua pesanan
    }

    public function orderDetail($orderId) {
        echo "Detail Pesanan dengan ID: " . htmlspecialchars($orderId) . " (Admin).";
        // Ambil dan tampilkan detail pesanan berdasarkan $orderId
    }
}
