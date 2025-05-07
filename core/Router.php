<?php
namespace Core;

class Router {
    protected $routes = [];

    public function add($method, $route, $controller, $action, $middleware = []) {
        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action, 'middleware' => $middleware];
    }

    public function dispatch($url, $method) {
        $url = $this->removeTrailingSlash($url);

        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $route => $params) {
                if (preg_match('#^' . $this->convertRouteToRegex($route) . '$#i', $url, $matches)) {
                    array_shift($matches); // Remove the full match

                    $controllerName = 'App\\Controllers\\' . $params['controller'];
                    $actionName = $params['action'];

                    if (class_exists($controllerName)) {
                        $controller = new $controllerName();
                        if (method_exists($controller, $actionName)) {
                            // Apply middleware (belum diimplementasikan)
                            call_user_func_array([$controller, $actionName], $matches);
                            return;
                        }
                    }
                }
            }
        }

        // Handle 404 Not Found
        http_response_code(404);
        echo "404 Not Found";
    }

    protected function convertRouteToRegex($route) {
        return preg_replace('/\/([a-zA-Z0-9]+)\/?/', '/?$1/?', preg_replace('/\//', '\\/', $route));
    }

    protected function removeTrailingSlash($url) {
        return rtrim($url, '/');
    }
}
