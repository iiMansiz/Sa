<?php
require_once 'core/Model.php';

class OrderItem extends Model {
    protected $table = 'order_items';

    public function getItemsByOrder($orderId) {
        $orderId = (int) $orderId;
        $sql = "SELECT oi.*, p.nama AS product_name, p.harga AS product_price
                FROM " . $this->table . " oi
                JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = " . $orderId;
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }
}
?>
