<?php
namespace App\Controllers;

class ReviewController {
    public function rateSeller($sellerId, $orderId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rating = $_POST['rating'] ?? '';
            $comment = $_POST['comment'] ?? '';
            // Logika untuk menyimpan rating penjual untuk order $orderId
            echo "Memberikan rating " . htmlspecialchars($rating) . " untuk penjual ID " . htmlspecialchars($sellerId) . " pada order ID " . htmlspecialchars($orderId) . " dengan komentar: " . htmlspecialchars($comment);
            // Redirect kembali ke detail order atau halaman lain
            header('Location: /orders/' . $orderId);
            exit;
        } else {
            echo "Form untuk Memberikan Rating Penjual ID " . htmlspecialchars($sellerId) . " untuk Order ID " . htmlspecialchars($orderId) . ".";
            // Tampilkan form rating penjual
        }
    }

    public function add($productId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rating = $_POST['rating'] ?? '';
            $comment = $_POST['comment'] ?? '';
            // Logika untuk menyimpan review produk dengan ID $productId
            echo "Menambahkan review untuk produk ID " . htmlspecialchars($productId) . " dengan rating " . htmlspecialchars($rating) . " dan komentar: " . htmlspecialchars($comment);
            // Redirect kembali ke detail produk
            header('Location: /product/' . $productId);
            exit;
        } else {
            // Mungkin redirect jika mencoba mengakses langsung dengan GET
            header('Location: /product/' . $productId);
            exit;
        }
    }
}
