<?php

class Controller {
    protected function view($path, $data) {

        // garante toke CSRF
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }

        // transformando array em variáveis
        extract($data);

        // converte "games.index" -> "games/idex.php"
        $path = str_replace('.', '/', $path);
        
        $content = "../app/views/{$path}.php";
        require "../app/views/layouts/app.php";
    }
}

?>
