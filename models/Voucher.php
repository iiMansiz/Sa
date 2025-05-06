<?php
require_once 'core/Model.php';

class Voucher extends Model {
    protected $table = 'vouchers';

    public function getActiveVouchers() {
        $now = date('Y-m-d H:i:s');
        return $this->where('status', true)
                    ->where('tanggal_mulai <=', $now)
                    ->where('tanggal_berakhir >=', $now)
                    ->where('jumlah_tersedia > jumlah_digunakan OR jumlah_tersedia IS NULL')
                    ->get();
    }

    public function getVoucherByCode($kode) {
        return $this->where('kode', $kode)->where('status', true)->first();
    }

    public function claimVoucher($voucherId, $userId) {
        return $this->db->query("INSERT INTO voucher_users (voucher_id, user_id) VALUES (" . (int) $voucherId . ", " . (int) $userId . ")");
    }

    public function isVoucherClaimed($voucherId, $userId) {
        return $this->db->query("SELECT * FROM voucher_users WHERE voucher_id = " . (int) $voucherId . " AND user_id = " . (int) $userId)->numRows() > 0;
    }

    public function incrementUsage($voucherId) {
        return $this->db->query("UPDATE " . $this->table . " SET jumlah_digunakan = jumlah_digunakan + 1 WHERE id = " . (int) $voucherId);
    }

    public function getSellerVouchers($sellerId) {
        return $this->where('seller_id', $sellerId)->get();
    }
}
?>
