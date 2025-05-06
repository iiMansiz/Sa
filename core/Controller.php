<?php
class Controller {
    protected function view($path, $data = []) {
        extract($data);
        $fullPath = 'views/' . $path . '.php';
        if (file_exists($fullPath)) {
            require_once 'views/layouts/main_layout.php'; // Asumsi ada layout utama
        } else {
            die("View not found: " . $path);
        }
    }

    protected function model($modelName) {
        $modelPath = 'models/' . $modelName . '.php';
        if (file_exists($modelPath)) {
            require_once $modelPath;
            return new $modelName();
        } else {
            die("Model not found: " . $modelName);
        }
    }

    protected function redirect($url) {
        header('Location: ' . $url);
        exit();
    }

    protected function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}
?>
