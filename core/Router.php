<?php
class Router {
    protected $routes = [];

    public function add($method, $route, $controller, $action) {
        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action];
    }

    public function dispatch($url, $method) {
        $url = trim($url, '/');
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $route => $target) {
                if (preg_match('#^' . $route . '$#i', $url, $matches)) {
                    $controllerName = $target['controller'];
                    $actionName = $target['action'];

                    require_once 'controllers/' . $controllerName . '.php';
                    $controller = new $controllerName();

                    // Remove the first element (full match)
                    array_shift($matches);

                    if (method_exists($controller, $actionName)) {
                        call_user_func_array([$controller, $actionName], $matches);
                        return;
                    }
                }
            }
        }
        require 'views/errors/404.php';
    }
}
?>
