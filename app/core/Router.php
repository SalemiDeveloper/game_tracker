<?php

class Router {
    private $routes = array();
    private $currentRoute;

    public function middleware($name) {
        $this->routes[$this->currentRoute['method']][$this->currentRoute['uri']]['middlewares'][] = $name;

        return $this;
    }

    public function get($uri, $action) {
        //$this->routes['GET'][$uri] = $action;

        $this->routes['GET'][$uri] = [
            'action'      => $action,
            'middlewares' => []
        ];

        $this->currentRoute = [
            'method' => 'GET',
            'uri'    => $uri
        ];

        return $this;
    }

    public function post($uri,$action) {
        //$this->routes['POST'][$uri] = $action;

        $this->routes['POST'][$uri] = [
            'action'      => $action,
            'middlewares' => []
        ];

        $this->currentRoute = [
            'method' => 'POST',
            'uri'    => $uri
        ];

        return $this;
    }

    public function dispatch($uri, $method) {
        if (!isset($this->routes[$method][$uri])) {

            http_response_code(404);
            echo "Página não encontrada.";
            return;
        }

        $route = $this->routes[$method][$uri];
        $action = $route['action'];

        foreach ($route['middlewares'] as $middleware) {
            if ($middleware === 'csrf') {
                require_once "../app/middlewares/CsrfMiddleware.php";
                (new CrsfMiddleware())->handle();
            }
        }

        // Se for uma string tipo "Controller@method"
        if (is_string($action)) {

            list($controller, $actionMethod) = explode('@', $action);

            require "../app/controllers/{$controller}.php";

            $controllerInstance = new $controller();

            return $controllerInstance->$actionMethod();
        }
    }
}