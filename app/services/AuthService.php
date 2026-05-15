<?php
namespace App\Services;
require_once "../app/models/User.php";

class AuthService {

    private $model;

    public function __construct() {
        $this->model = new \User();
    }

    public function register($data) {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = "Nome obrigatório.";
        }

        if (empty($data['email'])) {
            $errors['email'] = "Email obrigatório.";
        }

        if (empty($data['password'])) {
            $errors['password'] = "Senha obrigatória.";
        }

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors'  => $errors
            ];
        }

        $user = $this->model->findByEmail($data['email']);

        if ($user) {
            return [
                'success' => false,
                'errors' => [
                    'email' => ['Email já cadastrado.']
                ]
            ];
        }

        $data['password'] = password_hash(
            $data['password'],
            PASSWORD_DEFAULT
        );

        $this->model->create($data);

        return [
            'success' => true
        ];
    }

    public function login($data) {

        $errors = [];

        if (empty($data['email'])) {
            $errors['email'][] = "Email obrigatório";
        }

        if (empty($data['password'])) {
            $errors['password'][] = "Senha obrigatório";
        }

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors
            ];
        }

        $user = $this->model->findByEmail($data['email']);

        if (!$user) {
            return [
                'success' => false,
                'errors'  => [
                    'email' => ['Credenciais inválidas']
                ]
            ];
        }

        $passwordMatch = password_verify($data['password'], $user['password']);

        if (!$passwordMatch) {
            return [
                'success' => false,
                'errors'  => [
                    'email' => ['Credenciais inválidas']
                ]
            ];
        }

        $_SESSION['user'] = [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email']
        ];

        return [
            'success' => true
        ];
    }
}
?>