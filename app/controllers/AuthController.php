<?php

namespace App\Controllers;

use App\Services\AuthService;
//require_once "../config/database.php";
require_once __DIR__ . '/../../config/database.php';

class AuthController {

    private $db, $service;

    public function __construct() {
        $this->db = \Database::connect();
        $this->service = new AuthService($this->db);
    }

    public function showRegister() {
        require "../app/views/auth/register.php";
    }

    public function register() {

        $result = $this->service->register($_POST);

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

        $result = $this->service->login($_POST);

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