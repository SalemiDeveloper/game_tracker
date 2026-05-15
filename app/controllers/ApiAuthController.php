<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\Helpers\JWT;
use App\Models\RefreshToken;
//require_once "../app/models/RefreshToken.php";

class ApiAuthController {

    public function login() {
        header('Content-Type: application/json');

        $input = json_decode(
            file_get_contents('php://input'),
            true
        );

        $service = new AuthService();

        $result = $service->login($input);

        if (!$result['success']) {
            http_response_code(401);
            echo json_encode($result);
            return;
        }

        $user = $_SESSION['user'];

        $token = JWT::generate([
            'id'    => $user['id'],
            'email' => $user['email']
        ]);

        $refreshToken = bin2hex(random_bytes(64));
        $model = new RefreshToken();
        $model->deleteExpired();
        $model->create([
            'user_id' => $user['id'],
            'token' => $refreshToken,
            'expires_at' => date(
                'Y-m-d H:i:s',
                strtotime('+7 days')
            )
        ]);

        unset($_SESSION['user']);

        echo json_encode([
            'access_token' => $token,
            'refresh_token' => $refreshToken
        ]);
    }

    public function refresh() {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['refresh_token'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => "Refresh token obrigatório"
            ]);

            return;
        }

        $model = new RefreshToken();

        $storedToken = $model->find($input['refresh_token']);

        if (!$storedToken) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => "Refresh token inválido"
            ]);

            return;
        }

        if (strtotime($storedToken['expires_at']) < time()) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => "Refresh token expirado"
            ]);

            return;
        }

        $newAccessToken = JWT::generate([
            'id' => $storedToken['user_id']
        ]);

        echo json_encode([
            'access_token' => $newAccessToken
        ]);
    }

    public function logout() {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['refresh_token'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => "Refresh token obrigatório."
            ]);

            return;
        }

        $model = new RefreshToken();
        $deleted = $model->delete($input['refresh_token']);

        if (!$deleted) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => "Erro ao fazer logout."
            ]);

            return;
        }

        echo json_encode([
            'success' => true,
            'message' => "Logout realizado."
        ]);
    }
}

?>