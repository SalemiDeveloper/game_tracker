<?php

namespace App\Middlewares;

use App\Helpers\JWT;

class JWTMiddleware {

    public function handle() {
        $headers = getallheaders();

        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? null;

        if (!$authHeader) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => "Token não enviado."
            ]);
            exit;
        }

        $token = str_replace('Bearer ', '', $authHeader);
        $payload = JWT::validate($token);

        if (!$payload) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => "Token não enviado."
            ]);
            exit;
        }

        $_SERVER['user'] = $payload;

    }
}
?>