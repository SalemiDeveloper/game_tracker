<?php

class Router {
    private $routes = array();

    public function get($uri, $action) {
        //die("this->routes['GET'][$uri] = $action"); this->routes['GET'][/games] = GameController@index
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri,$action) {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch($uri, $method) {
        if (!isset($this->routes[$method][$uri])) {

            http_response_code(404);
            echo "Página não encontrada.";
            return;
        }

        $action = $this->routes[$method][$uri];

        // Se for uma string tipo "Controller@method"
        if (is_string($action)) {

            list($controller, $actionMethod) = explode('@', $action);

            require "../app/controllers/{$controller}.php";

            $controllerInstance = new $controller();

            return $controllerInstance->$actionMethod();
        }
    }
}