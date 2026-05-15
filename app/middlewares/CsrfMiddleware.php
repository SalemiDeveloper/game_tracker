<?php 

namespace App\Middlewares;

class CrsfMiddleware {

    public function handle() {
        if (!isset($_POST['csrf']) || $_POST['csrf'] !== $_SESSION['csrf']) {
            die("CSRF token inválido");
        }
    }
}

?>