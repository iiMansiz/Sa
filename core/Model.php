<?php
namespace Core;

use PDO;
use PDOException;

class Model {
    protected $db;
    protected $table;
    protected $allowedFields = [];

    public function __construct() {
        $config = require '../config/database.php';
        try {
            $this->db = new PDO("mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'], $config['username'], $config['password']);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getDB() {
        return $this->db;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function where($column, $value) {
        $this->whereClause = "WHERE {$column} = :value";
        $this->whereValue = $value;
        return $this;
    }

    public function orderBy($column, $direction = 'ASC') {
        $this->orderByClause = "ORDER BY {$column} {$direction}";
        return $this;
    }

    public function get() {
        $sql = "SELECT * FROM {$this->table} " . ($this->whereClause ?? '') . " " . ($this->orderByClause ?? '');
        $stmt = $this->db->prepare($sql);
        if (isset($this->whereValue)) {
            $stmt->bindParam(':value', $this->whereValue);
        }
        $stmt->execute();
        $this->resetQueryClauses();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first() {
        $sql = "SELECT * FROM {$this->table} " . ($this->whereClause ?? '');
        $stmt = $this->db->prepare($sql);
        if (isset($this->whereValue)) {
            $stmt->bindParam(':value', $this->whereValue);
        }
        $stmt->execute();
        $this->resetQueryClauses();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert(array $data) {
        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute($data);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            // Log error
            return false;
        }
    }

    public function update($id, array $data) {
        $setClauses = [];
        foreach (array_keys($data) as $field) {
            $setClauses[] = "{$field} = :{$field}";
        }
        $sql = "UPDATE {$this->table} SET " . implode(', ', $setClauses) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;
        try {
            return $stmt->execute($data);
        } catch (PDOException $e) {
            // Log error
            return false;
        }
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log error
            return false;
        }
    }

    protected function resetQueryClauses() {
        $this->whereClause = null;
        $this->whereValue = null;
        $this->orderByClause = null;
    }
}
