<?php
require_once 'core/Model.php';

class Product extends Model {
    protected $table = 'products';

    // ... (metode sebelumnya)

    public function getProductImages($productId) {
        $sql = "SELECT * FROM product_images WHERE product_id = " . (int) $productId;
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    public function addProductImage($productId, $path) {
        return $this->db->query("INSERT INTO product_images (product_id, path) VALUES (" . (int) $productId . ", '" . $this->db->escapeString($path) . "')");
    }

    public function deleteProductImage($imageId) {
        return $this->db->query("DELETE FROM product_images WHERE id = " . (int) $imageId);
    }

    public function getProductVariations($productId) {
        $sql = "SELECT * FROM product_variations WHERE product_id = " . (int) $productId;
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    public function addProductVariation($data) {
        $columns = implode(', ', array_keys($data));
        $values = "'" . implode("', '", array_map([$this->db, 'escapeString'], array_values($data))) . "'";
        $sql = "INSERT INTO product_variations (" . $columns . ") VALUES (" . $values . ")";
        return $this->db->query($sql);
    }

    public function updateProductVariation($id, $data) {
        $setClauses = [];
        foreach ($data as $key => $value) {
            $setClauses[] = $key . " = '" . $this->db->escapeString($value) . "'";
        }
        $sql = "UPDATE product_variations SET " . implode(', ', $setClauses) . " WHERE id = " . (int) $id;
        return $this->db->query($sql);
    }

    public function deleteProductVariation($id) {
        return $this->db->query("DELETE FROM product_variations WHERE id = " . (int) $id);
    }
}
?>
