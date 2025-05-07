<?php
namespace Core;

class Controller {
    protected function model($model) {
        $modelPath = '../app/Models/' . $model . '.php';
        if (file_exists($modelPath)) {
            require_once $modelPath;
            $modelClass = 'App\\Models\\' . $model;
            return new $modelClass();
        }
        return null;
    }

    protected function view($view, $data = [], $layout = 'main_layout') {
        $viewPath = '../views/' . $view . '.php';
        $layoutPath = '../views/layouts/' . $layout . '.php';

        if (file_exists($viewPath) && file_exists($layoutPath)) {
            require_once $layoutPath;
        } elseif (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("View {$view} not found.");
        }
    }

    protected function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit();
    }
}
