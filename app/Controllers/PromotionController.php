<?php
namespace App\Controllers;

class PromotionController {
    public function adminVouchers() {
        echo "Halaman daftar voucher (Admin).";
        // Di sini Anda akan mengambil dan menampilkan daftar voucher (untuk admin)
    }

    public function adminAddVoucher() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Proses penambahan voucher baru berdasarkan data POST
            $code = $_POST['code'] ?? '';
            $discount = $_POST['discount'] ?? '';
            // ... ambil data lainnya

            // Lakukan validasi dan penyimpanan data voucher ke database (menggunakan model)

            // Setelah berhasil, mungkin redirect ke halaman daftar voucher admin
            header('Location: /admin/vouchers');
            exit;
        } else {
            echo "Form untuk menambahkan voucher baru (Admin).";
            // Di sini Anda akan menampilkan form penambahan voucher
        }
    }

    public function adminEditVoucher($voucherId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Proses pembaruan data voucher berdasarkan data POST dan $voucherId
            $discount = $_POST['discount'] ?? '';
            // ... ambil data lainnya

            // Lakukan validasi dan pembaruan data voucher di database (menggunakan model)

            // Setelah berhasil, mungkin redirect ke halaman daftar voucher admin
            header('Location: /admin/vouchers');
            exit;
        } else {
            echo "Form untuk mengedit voucher dengan ID: " . htmlspecialchars($voucherId) . " (Admin).";
            // Di sini Anda akan menampilkan form edit voucher dengan data voucher saat ini
        }
    }

    public function adminDeleteVoucher($voucherId) {
        // Logika untuk menghapus voucher dengan ID $voucherId
        echo "Menghapus voucher dengan ID: " . htmlspecialchars($voucherId) . " (Admin).";
        // Setelah berhasil, mungkin redirect kembali ke halaman daftar voucher admin
        header('Location: /admin/vouchers');
        exit;
    }

    // ... method-method lain untuk rute voucher seller dan promosi admin
}
