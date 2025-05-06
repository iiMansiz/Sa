<?php
require_once 'core/Model.php';

class WishlistItem extends Model {
    protected $table = 'wishlist_items';

    public function getUserWishlist($userId) {
        $sql = "SELECT wi.*, p.nama AS product_name, p.harga, p.gambar
                FROM " . $this->table . " wi
                JOIN products p ON wi.product_id = p.id
                WHERE wi.user_id = " . (int) $userId;
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    public function addItem($userId, $productId) {
        return $this->insert(['user_id' => $userId, 'product_id' => $productId]);
    }

    public function removeItem($userId, $productId) {
        return $this->where(['user_id' => $userId, 'product_id' => $productId])->delete();
    }

    public function isItemInWishlist($userId, $productId) {
        return $this->where(['user_id' => $userId, 'product_id' => $productId])->count() > 0;
    }
}
?>
