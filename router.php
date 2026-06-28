<?php

// Acho que não estou utilizando mais este arquivo, vou deixar o die() para confirmar.
die('entrou no router');
$path = parse_url(
    $_SERVER['REQUEST_URI'],
    PHP_URL_PATH
);

$file = __DIR__ . '/public' . $path;

if (
    $path !== '/'
    && file_exists($file)
) {
    return false;
}

require __DIR__ . '/public/index.php';