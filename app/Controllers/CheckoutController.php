<?php
namespace App\Controllers;

class CheckoutController {
    public function index() {
        echo "Halaman Checkout.";
        // Tampilkan ringkasan pesanan, form pengiriman, dll.
    }

    public function processOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Proses pemesanan: ambil data dari POST, validasi, buat pesanan di database
            // Kurangi stok produk, kirim notifikasi, dll.
            echo "Memproses Pesanan.";
            // Setelah berhasil, redirect ke halaman konfirmasi atau detail pesanan
            header('Location: /orders');
            exit;
        } else {
            // Metode bukan POST, redirect kembali ke halaman checkout
            header('Location: /checkout');
            exit;
        }
    }
}
