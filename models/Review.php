<?php
require_once 'core/Model.php';

class Review extends Model {
    protected $table = 'reviews';

    public function getReviewsByProduct($productId) {
        $sql = "SELECT r.*, u.nama AS user_name FROM " . $this->table . " r JOIN users u ON r.user_id = u.id WHERE r.product_id = " . (int) $productId . " ORDER BY r.created_at DESC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    public function addReview($data) {
        $columns = implode(', ', array_keys($data));
        $values = "'" . implode("', '", array_map([$this->db, 'escapeString'], array_values($data))) . "'";
        $sql = "INSERT INTO " . $this->table . " (" . $columns . ") VALUES (" . $values . ")";
        return $this->db->query($sql);
    }
}
?>
