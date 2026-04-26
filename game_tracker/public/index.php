<?php 

//session_start();
// Código para rodar servidor no terminal: php -S localhost:8000 -t public

require "../app/core/Router.php";
$router = new Router();

require "../routes/web.php";

// Garantindo que vai rodar a URL no Laragon -------
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// remove a pasta do projeto da URL
$basePath = '/game_tracker/public';
$uri = str_replace($basePath, '', $uri);

// garante que pelo menos seja "/"
if ($uri === '') {
    $uri = '/';
}
// -----------------------------------------------

$method = $_SERVER['REQUEST_METHOD'];
$action = $router->dispatch($uri, $method);

if (is_callable($action)) {
    $action();
}
?>