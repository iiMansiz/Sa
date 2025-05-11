<?php
namespace Core;

use PDO;
use PDOException;

class Database {
    protected $pdo;
    protected $host = 'localhost';
    protected $dbname = 'nama_database_anda';
    protected $user = 'nama_pengguna_db';
    protected $password = 'kata_sandi_db';

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Koneksi database gagal: " . $e->getMessage());
        }
    }

    public function fetchAll($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchOne($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data) {
        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function update($table, $data, $where) {
        $setClauses = [];
        foreach ($data as $key => $value) {
            $setClauses[] = "{$key} = :{$key}";
        }
        $whereClauses = [];
        foreach ($where as $key => $value) {
            $whereClauses[] = "{$key} = :where_{$key}";
        }
        $sql = "UPDATE {$table} SET " . implode(', ', $setClauses) . " WHERE " . implode(' AND ', $whereClauses);
        $stmt = $this->pdo->prepare($sql);
        $params = array_merge($data, array_combine(array_map(function($k){ return 'where_'.$k; }, array_keys($where)), array_values($where)));
        return $stmt->execute($params);
    }

    public function delete($table, $where) {
        $whereClauses = [];
        foreach ($where as $key => $value) {
            $whereClauses[] = "{$key} = :{$key}";
        }
        $sql = "DELETE FROM {$table} WHERE " . implode(' AND ', $whereClauses);
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($where);
    }

    public function getPDO() {
        return $this->pdo;
    }
}
