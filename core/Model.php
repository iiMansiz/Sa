<?php
class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function all() {
        $sql = "SELECT * FROM " . $this->table;
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    public function find($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = " . (int) $id;
        $result = $this->db->query($sql);
        return $this->db->fetch($result);
    }

    public function where($column, $value, $operator = '=') {
        $value = $this->db->escapeString($value);
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $column . " " . $operator . " '" . $value . "'";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    public function insert($data) {
        $columns = implode(', ', array_keys($data));
        $values = "'" . implode("', '", array_map([$this->db, 'escapeString'], array_values($data))) . "'";
        $sql = "INSERT INTO " . $this->table . " (" . $columns . ") VALUES (" . $values . ")";
        $this->db->query($sql);
        return $this->db->getInstance()->insert_id;
    }

    public function update($id, $data) {
        $setClauses = [];
        foreach ($data as $key => $value) {
            $setClauses[] = $key . " = '" . $this->db->escapeString($value) . "'";
        }
        $sql = "UPDATE " . $this->table . " SET " . implode(', ', $setClauses) . " WHERE id = " . (int) $id;
        return $this->db->query($sql);
    }

    public function delete($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE id = " . (int) $id;
        return $this->db->query($sql);
    }
}
?>
