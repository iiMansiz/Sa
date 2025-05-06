<?php
require_once 'core/Model.php';

class Product extends Model {
    protected $table = 'products';

    public function getProductsWithCategory($categoryId = null) {
        $sql = "SELECT p.*, c.nama AS category_name FROM " . $this->table . " p LEFT JOIN categories c ON p.category_id = c.id";
        if ($categoryId) {
            $sql .= " WHERE p.category_id = " . (int) $categoryId;
        }
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    public function getProductsBySeller($sellerId) {
        return $this->where('seller_id', $sellerId);
    }
}
?>
