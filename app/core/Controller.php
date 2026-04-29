<?php

class Controller {
    protected function view($path, $data) {

        // transformando array em variáveis
        extract($data);

        // converte "games.index" -> "games/idex.php"
        $path = str_replace('.', '/', $path);
        
        $content = "../app/views/{$path}.php";
        require "../app/views/layouts/app.php";
    }
}

?>
