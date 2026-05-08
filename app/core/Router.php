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

    public function put($uri, $action) {
        $this->routes['PUT'][$uri] = [
            'action' => $action,
            'middlewares' => []
        ];

        $this->currentRoute = [
            'method' => 'PUT',
            'uri' => $uri
        ];

        return $this;
    }

    public function delete($uri, $action) {

        $this->routes['DELETE'][$uri] = [
            'action' => $action,
            'middlewares' => []
        ];

        $this->currentRoute = [
            'method' => 'DELETE',
            'uri' => $uri
        ];

        return $this;
    }

    public function dispatch($uri, $method) {

        $found = $this->findRouter($uri, $method);

        if (!$found) {
            http_response_code(404);
            echo "Página não encontrada.";
            return;
        }

        $route = $found['route'];
        $params = $found['params'];

        $action = $route['action'];

        foreach ($route['middlewares'] as $middleware) {
            if ($middleware === 'csrf') {
                require_once "../app/middlewares/CsrfMiddleware.php";
                (new CrsfMiddleware())->handle();
            }

            if ($middleware === 'auth') {
                require_once "../app/middlewares/AuthMiddleware.php";
                (new AuthMiddleware())->handle();
            }
        }

        // Se for uma string tipo "Controller@method"
        if (is_string($action)) {

            list($controller, $actionMethod) = explode('@', $action);

            require "../app/controllers/{$controller}.php";

            $controllerInstance = new $controller();

            //return $controllerInstance->$actionMethod();
            return call_user_func_array(
                [$controllerInstance, $actionMethod],
                $params
            );
        }
    }

    private function findRouter($uri, $method) {

        foreach ($this->routes[$method] as $route => $data) {

            $pattern = preg_replace('/\{[a-zA-Z]+\}/', '([0-9]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);

                return [
                    'route'  => $data,
                    'params' => $matches
                ];
            }
        }

        return null;
    }
}