<?php
namespace App\Controllers;

class PaymentController {
    public function index($orderId) {
        echo "Halaman Pembayaran untuk Pesanan ID: " . htmlspecialchars($orderId) . ".";
        // Tampilkan informasi pembayaran dan form untuk memilih metode pembayaran
    }

    public function processPayment($orderId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $paymentMethod = $_POST['payment_method'] ?? '';
            // Logika untuk memproses pembayaran untuk pesanan dengan ID $orderId
            // Integrasi dengan gateway pembayaran, update status pembayaran di database
            echo "Memproses Pembayaran untuk Pesanan ID: " . htmlspecialchars($orderId) . " menggunakan metode: " . htmlspecialchars($paymentMethod);
            // Setelah berhasil, redirect ke halaman konfirmasi pembayaran atau detail pesanan
            header('Location: /orders/' . $orderId);
            exit;
        } else {
            // Metode bukan POST, redirect kembali ke halaman pembayaran
            header('Location: /payment/' . $orderId);
            exit;
        }
    }
}
