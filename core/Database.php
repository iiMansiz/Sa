<?php
class Database {
    private static $instance = null;
    private $conn;
    private $config;

    private function __construct() {
        $this->config = require 'config/database.php';
        $this->conn = new mysqli(
            $this->config['host'],
            $this->config['username'],
            $this->config['password'],
            $this->config['database']
        );

        if ($this->conn->connect_error) {
            die("Koneksi database gagal: " . $this->conn->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }

    public function query($sql) {
        return self::getInstance()->query($sql);
    }

    public function fetch($result) {
        return $result->fetch_assoc();
    }

    public function fetchAll($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function escapeString($string) {
        return self::getInstance()->real_escape_string($string);
    }
}
?>
