<?php
require_once 'core/Model.php';

class Report extends Model {
    protected $table = 'reports';

    public function generateReport($type, $title, $data) {
        $data = [
            'type' => $type,
            'title' => $title,
            'data' => json_encode($data) // Contoh menyimpan data sebagai JSON
        ];
        return $this->insert($data);
    }

    public function getReportsByType($type, $limit = 10) {
        return $this->where('type', $type)->orderBy('created_at', 'DESC')->limit($limit)->get();
    }

    // Metode lain untuk mengambil dan memproses data laporan
}
?>
