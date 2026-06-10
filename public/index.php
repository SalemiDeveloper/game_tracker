<?php

/* 
    PARA REAL(CMD/PowerShell):   
        php -S localhost:8000 -t public

    PARA TESTES(CMD): 
        set APP_ENV=testing && php -S localhost:8000 -t public
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
$envFile = '.env';

if (trim(getenv('APP_ENV')) === 'testing') {
    $envFile = '.env.testing';
}

$dotenv = Dotenv::createImmutable(__DIR__ . '/../',$envFile);
$dotenv->load();

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

use App\Core\Router;
$router = new Router();

require __DIR__ . '/../routes/web.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Para Laragon/web ----------------
$basePath = '/game_tracker/public';

if (str_starts_with($uri, $basePath)) {
    $uri = str_replace($basePath, '', $uri);
}

if ($uri === '') {
    $uri = '/';
}
// ---------------------------------

$method = $_SERVER['REQUEST_METHOD'];
$action = $router->dispatch($uri, $method);

if (is_callable($action)) {
    $action();
}
?>