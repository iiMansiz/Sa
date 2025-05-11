<?php
namespace App\Models;

use Core\Database; // Asumsi Anda memiliki kelas Database di Core

class Ticket {
    protected $db;
    protected $table = 'tickets';

    public function __construct() {
        $this->db = new Database(); // Inisialisasi koneksi database
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM {$this->table}");
    }

    public function getById($id) {
        return $this->db->fetchOne("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }

    public function create($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    // Anda bisa menambahkan method lain yang spesifik untuk tiket,
    // misalnya untuk mengambil tiket berdasarkan status, user_id, dll.
}
