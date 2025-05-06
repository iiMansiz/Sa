<?php
require_once 'core/Model.php';

class Promotion extends Model {
    protected $table = 'promotions';

    public function getActivePromotions() {
        $now = date('Y-m-d H:i:s');
        $sql = "SELECT * FROM " . $this->table . " WHERE status = TRUE AND (tanggal_berakhir IS NULL OR tanggal_berakhir >= '" . $now . "') AND (tanggal_mulai IS NULL OR tanggal_mulai <= '" . $now . "')";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    public function getPromotionsForProduct($productId) {
        $now = date('Y-m-d H:i:s');
        $sql = "SELECT p.* FROM " . $this->table . " p
                JOIN promotion_products pp ON p.id = pp.promotion_id
                WHERE pp.product_id = " . (int) $productId . "
                AND p.status = TRUE
                AND (p.tanggal_berakhir IS NULL OR p.tanggal_berakhir >= '" . $now . "')
                AND (p.tanggal_mulai IS NULL OR p.tanggal_mulai <= '" . $now . "')";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    public function addProductToPromotion($promotionId, $productId) {
        return $this->db->query("INSERT INTO promotion_products (promotion_id, product_id) VALUES (" . (int) $promotionId . ", " . (int) $productId . ")");
    }

    public function removeProductFromPromotion($promotionId, $productId) {
        return $this->db->query("DELETE FROM promotion_products WHERE promotion_id = " . (int) $promotionId . " AND product_id = " . (int) $productId);
    }
}
?>
