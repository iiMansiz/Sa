<?php
namespace App\Controllers;

class OrderController {
    public function index() {
        echo "Halaman Daftar Pesanan Anda.";
        // Tampilkan daftar pesanan pembeli yang login
    }

    public function detail($orderId) {
        echo "Detail Pesanan dengan ID: " . htmlspecialchars($orderId) . ".";
        // Tampilkan detail pesanan berdasarkan $orderId
    }

    public function sellerOrderList() {
        echo "Halaman Daftar Pesanan (Penjual).";
        // Tampilkan daftar pesanan yang melibatkan produk penjual yang login
    }

    public function sellerOrderDetail($orderId) {
        echo "Detail Pesanan dengan ID: " . htmlspecialchars($orderId) . " (Penjual).";
        // Tampilkan detail pesanan berdasarkan $orderId (hanya yang relevan dengan penjual)
    }

    public function adminOrderList() {
        echo "Halaman Daftar Pesanan (Admin).";
        // Tampilkan daftar semua pesanan untuk admin
    }

    public function adminOrderDetail($orderId) {
        echo "Detail Pesanan dengan ID: " . htmlspecialchars($orderId) . " (Admin).";
        // Tampilkan detail pesanan berdasarkan $orderId untuk admin
    }

    public function updateOrderStatus($orderId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? '';
            // Logika untuk memperbarui status pesanan dengan ID $orderId menjadi $status
            echo "Memperbarui status pesanan " . htmlspecialchars($orderId) . " menjadi: " . htmlspecialchars($status);
            // Redirect kembali ke detail pesanan atau daftar pesanan
            header('Location: /orders/' . $orderId); // Atau /admin/orders atau /seller/orders
            exit;
        } else {
            // Metode bukan POST, redirect kembali ke detail pesanan
            header('Location: /orders/' . $orderId);
            exit;
        }
    }
}
