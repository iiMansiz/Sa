<?php
namespace App\Controllers;

class CategoryController {
    public function index() {
        echo "Halaman Daftar Kategori (Admin).";
        // Ambil dan tampilkan daftar semua kategori
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            // Validasi dan simpan kategori baru ke database
            echo "Menambahkan kategori: " . htmlspecialchars($name);
            header('Location: /admin/categories');
            exit;
        } else {
            echo "Form untuk Menambah Kategori Baru.";
            // Tampilkan form tambah kategori
        }
    }

    public function edit($categoryId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            // Validasi dan perbarui kategori di database berdasarkan $categoryId
            echo "Memperbarui kategori dengan ID: " . htmlspecialchars($categoryId) . " menjadi: " . htmlspecialchars($name);
            header('Location: /admin/categories');
            exit;
        } else {
            echo "Form untuk Mengedit Kategori dengan ID: " . htmlspecialchars($categoryId) . ".";
            // Tampilkan form edit kategori dengan data kategori saat ini
        }
    }

    public function delete($categoryId) {
        // Logika untuk menghapus kategori dengan ID $categoryId
        echo "Menghapus kategori dengan ID: " . htmlspecialchars($categoryId) . ".";
        header('Location: /admin/categories');
        exit;
    }
}
