<?php 

namespace App\Middlewares;

class CsrfMiddleware {

    public function handle() {
        if (!isset($_POST['csrf']) || $_POST['csrf'] !== $_SESSION['csrf']) {
            die("CSRF token inválido");
        }
    }
}

?>