<?php
namespace App\Controllers;

class AdminTicketController {
    public function index() {
        echo "Halaman daftar semua tiket (Admin).";
        // Di sini Anda akan mengambil dan menampilkan daftar semua tiket
    }

    public function view($ticketId) {
        echo "Melihat detail tiket dengan ID: " . htmlspecialchars($ticketId) . " (Admin)";
        // Di sini Anda akan mengambil dan menampilkan detail tiket berdasarkan $ticketId (untuk admin)
    }

    public function reply($ticketId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Proses pengiriman balasan tiket oleh admin berdasarkan data POST
            $replyMessage = $_POST['reply_message'] ?? '';

            // Lakukan validasi dan penyimpanan balasan admin ke database (menggunakan model)

            // Setelah berhasil, mungkin redirect kembali ke halaman detail tiket admin
            header('Location: /admin/tickets/view/' . $ticketId);
            exit;
        } else {
            echo "Form untuk membalas tiket dengan ID: " . htmlspecialchars($ticketId) . " (Admin)";
            // Di sini Anda akan menampilkan form balasan tiket (untuk admin)
        }
    }

    public function close($ticketId) {
        // Logika untuk menutup tiket dengan ID $ticketId
        echo "Menutup tiket dengan ID: " . htmlspecialchars($ticketId);
        // Setelah berhasil, mungkin redirect kembali ke halaman daftar tiket admin
        header('Location: /admin/tickets');
        exit;
    }
}
