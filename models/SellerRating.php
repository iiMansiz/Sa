<?php
require_once 'core/Model.php';

class SellerRating extends Model {
    protected $table = 'seller_ratings';

    public function getRatingsBySeller($sellerId) {
        $sql = "SELECT sr.*, u.nama AS user_name FROM " . $this->table . " sr JOIN users u ON sr.user_id = u.id WHERE sr.seller_id = " . (int) $sellerId . " ORDER BY sr.created_at DESC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    public function addRating($data) {
        return $this->insert($data);
    }

    public function getAverageRating($sellerId) {
        $result = $this->db->query("SELECT AVG(rating) AS average_rating FROM " . $this->table . " WHERE seller_id = " . (int) $sellerId);
        $row = $this->db->fetch($result);
        return $row ? round((float)$row['average_rating'], 2) : 0;
    }

    public function checkUserRated($sellerId, $userId) {
        return $this->where(['seller_id' => $sellerId, 'user_id' => $userId]);
    }
}
?>
