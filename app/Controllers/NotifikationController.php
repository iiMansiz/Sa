<?php
namespace App\Controllers;

class NotificationController {
    public function index() {
        echo "Halaman Notifikasi.";
        // Ambil dan tampilkan notifikasi pengguna yang login
    }

    public function markAsRead($notificationId) {
        // Logika untuk menandai notifikasi dengan ID $notificationId sebagai sudah dibaca
        echo "Menandai notifikasi ID " . htmlspecialchars($notificationId) . " sebagai sudah dibaca.";
        // Redirect kembali ke halaman notifikasi
        header('Location: /notifications');
        exit;
    }
}
