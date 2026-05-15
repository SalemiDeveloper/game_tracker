<?php

use App\Services\AuthService;

class AuthController {

    public function showRegister() {
        require "../app/views/auth/register.php";
    }

    public function register() {

        $service = new AuthService();

        $result = $service->register($_POST);

        if (!$result['success']) {

            $_SESSION['errors'] = $result['errors'];
            $_SESSION['old'] = $_POST;

            header('Location: /register');
        }

        $_SESSION['success'] = "Usuário cadastrado.";

        header('Location: /register');
        exit;
    }

    public function showLogin() {
        require "../app/views/auth/login.php";
    }

    public function login() {

        $service = new AuthService();
        $result = $service->login($_POST);

        if (!$result['success']) {
            $_SESSION['errors'] = $result['errors'];
            $_SESSION['old'] = $_POST;

            header("Location: /login");
            exit;
        }

        header("Location: /games");
        exit;
    }

    public function logout() {
        unset($_SESSION['user']);

        header('Location: /login');
        exit;
    }
}


?>