<?php
require_once 'core/Model.php';

class User extends Model {
    protected $table = 'users';

    public function getUserByEmail($email) {
        $email = $this->db->escapeString($email);
        $sql = "SELECT * FROM " . $this->table . " WHERE email = '" . $email . "'";
        $result = $this->db->query($sql);
        return $this->db->fetch($result);
    }
}
?>
