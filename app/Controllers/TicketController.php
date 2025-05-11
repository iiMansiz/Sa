<?php
namespace App\Controllers;

class TicketController {
    public function index() {
        echo "Halaman daftar tiket Anda.";
        // Di sini Anda akan mengambil dan menampilkan daftar tiket pembeli
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Proses pembuatan tiket baru berdasarkan data POST
            $subject = $_POST['subject'] ?? '';
            $message = $_POST['message'] ?? '';

            // Lakukan validasi dan penyimpanan data tiket ke database (menggunakan model)

            // Setelah berhasil, mungkin redirect ke halaman daftar tiket
            header('Location: /tickets');
            exit;
        } else {
            echo "Form untuk membuat tiket baru.";
            // Di sini Anda akan menampilkan form pembuatan tiket
        }
    }

    public function view($ticketId) {
        echo "Melihat detail tiket dengan ID: " . htmlspecialchars($ticketId);
        // Di sini Anda akan mengambil dan menampilkan detail tiket berdasarkan $ticketId
    }

    public function reply($ticketId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Proses pengiriman balasan tiket berdasarkan data POST
            $replyMessage = $_POST['reply_message'] ?? '';

            // Lakukan validasi dan penyimpanan balasan ke database (menggunakan model)

            // Setelah berhasil, mungkin redirect kembali ke halaman detail tiket
            header('Location: /tickets/view/' . $ticketId);
            exit;
        } else {
            echo "Form untuk membalas tiket dengan ID: " . htmlspecialchars($ticketId);
            // Di sini Anda akan menampilkan form balasan tiket
        }
    }
}
