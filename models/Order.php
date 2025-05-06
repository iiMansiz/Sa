<?php
require_once 'core/Model.php';

class Order extends Model {
    protected $table = 'orders';

    public function getOrdersByUser($userId, $role = 'buyer') {
        $userId = (int) $userId;
        $roleColumn = ($role === 'seller') ? 'seller_id' : 'buyer_id';
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $roleColumn . " = " . $userId . " ORDER BY created_at DESC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }
}
?>
