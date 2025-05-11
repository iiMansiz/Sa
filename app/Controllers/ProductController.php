<?php
namespace App\Controllers;

class ProductController {
    public function detail($productId) {
        echo "Halaman detail produk dengan ID: " . htmlspecialchars($productId);
        // Ambil detail produk dari database berdasarkan $productId dan tampilkan
    }
}
