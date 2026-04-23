<?php

class Router {
    private $routes = array();

    public function get($uri, $action) {
        $this->routes['GET'][$uri] = $action;
    }

    public function dispatch($uri, $method) {
        if (isset($this->routes[$method][$uri])) {
            return $this->routes[$method][$uri];
        }

        http_response_code(404);
        echo "Página não encontrada.";
    }
}