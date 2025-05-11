<?php
namespace App\Controllers;

class CartController {
    public function index() {
        echo "Halaman Keranjang Belanja.";
        // Tampilkan isi keranjang belanja dari sesi atau database
    }

    public function add($productId) {
        // Logika untuk menambahkan produk dengan ID $productId ke keranjang belanja
        echo "Menambahkan produk dengan ID: " . htmlspecialchars($productId) . " ke keranjang.";
        // Mungkin redirect kembali ke halaman produk atau keranjang
        header('Location: /cart');
        exit;
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Proses pembaruan jumlah item dalam keranjang berdasarkan data POST
            // Contoh: $_POST['product_id'] => quantity
            print_r($_POST);
            echo "Memperbarui keranjang belanja.";
            // Redirect kembali ke halaman keranjang
            header('Location: /cart');
            exit;
        } else {
            // Metode bukan POST, mungkin redirect atau tampilkan pesan error
            header('Location: /cart');
            exit;
        }
    }

    public function remove($itemId) {
        // Logika untuk menghapus item dengan ID $itemId dari keranjang belanja
        echo "Menghapus item dengan ID: " . htmlspecialchars($itemId) . " dari keranjang.";
        // Redirect kembali ke halaman keranjang
        header('Location: /cart');
        exit;
    }

    public function clear() {
        // Logika untuk mengosongkan seluruh keranjang belanja
        echo "Mengosongkan keranjang belanja.";
        // Redirect kembali ke halaman keranjang
        header('Location: /cart');
        exit;
    }

    public function applyVoucher() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $voucherCode = $_POST['voucher_code'] ?? '';
            // Logika untuk memeriksa apakah voucher valid dan menerapkannya ke keranjang
            echo "Mencoba menerapkan voucher: " . htmlspecialchars($voucherCode);
            // Mungkin redirect kembali ke halaman keranjang
            header('Location: /cart');
            exit;
        } else {
            // Metode bukan POST, mungkin redirect atau tampilkan pesan error
            header('Location: /cart');
            exit;
        }
    }
}
