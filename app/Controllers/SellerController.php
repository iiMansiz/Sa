<?php
namespace App\Controllers;

class SellerController {
    public function dashboard() {
        echo "Halaman Dashboard Penjual.";
        // Tampilkan statistik dan informasi penting untuk penjual
    }

    public function productList() {
        echo "Halaman Daftar Produk Saya (Penjual).";
        // Ambil dan tampilkan daftar produk yang dimiliki oleh penjual yang login
    }

    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Proses penambahan produk baru berdasarkan data POST
            // ... ambil data produk

            // Validasi dan simpan produk ke database (menggunakan model)

            // Redirect ke daftar produk penjual
            header('Location: /seller/products');
            exit;
        } else {
            echo "Form untuk Menambah Produk Baru.";
            // Tampilkan form tambah produk
        }
    }

    public function editProduct($productId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Proses pembaruan produk berdasarkan data POST dan $productId
            // ... ambil data produk yang diubah

            // Validasi dan perbarui produk di database (menggunakan model)

            // Redirect ke daftar produk penjual
            header('Location: /seller/products');
            exit;
        } else {
            echo "Form untuk Mengedit Produk dengan ID: " . htmlspecialchars($productId) . ".";
            // Tampilkan form edit produk dengan data produk saat ini
        }
    }

    public function orderList() {
        echo "Halaman Daftar Pesanan Saya (Penjual).";
        // Ambil dan tampilkan daftar pesanan yang melibatkan produk penjual
    }

    public function orderDetail($orderId) {
        echo "Detail Pesanan dengan ID: " . htmlspecialchars($orderId) . " (Penjual).";
        // Ambil dan tampilkan detail pesanan berdasarkan $orderId (hanya yang relevan dengan penjual)
    }

    public function deleteProductImage($imageId) {
        // Logika untuk menghapus gambar produk dengan ID $imageId
        echo "Menghapus gambar produk dengan ID: " . htmlspecialchars($imageId) . ".";
        // Mungkin redirect kembali ke halaman edit produk
        // header('Location: /seller/products/edit/' . $productId); // Perlu tahu $productId di sini
        exit;
    }

    public function deleteProductVariation($variationId) {
        // Logika untuk menghapus variasi produk dengan ID $variationId
        echo "Menghapus variasi produk dengan ID: " . htmlspecialchars($variationId) . ".";
        // Mungkin redirect kembali ke halaman edit produk
        // header('Location: /seller/products/edit/' . $productId); // Perlu tahu $productId di sini
        exit;
    }
}
