<?php
namespace App\Controllers;

class ReportController {
    public function adminSalesOverview() {
        echo "Laporan Ringkasan Penjualan (Admin).";
        // Ambil dan tampilkan data ringkasan penjualan untuk admin
    }

    public function adminProductPerformance() {
        echo "Laporan Performa Produk (Admin).";
        // Ambil dan tampilkan data performa produk untuk admin
    }

    public function sellerSalesOverview() {
        echo "Laporan Ringkasan Penjualan Saya (Penjual).";
        // Ambil dan tampilkan data ringkasan penjualan untuk penjual yang login
    }

    public function sellerProductPerformance() {
        echo "Laporan Performa Produk Saya (Penjual).";
        // Ambil dan tampilkan data performa produk untuk penjual yang login
    }
}
