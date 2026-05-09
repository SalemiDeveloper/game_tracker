<?php 
require_once "../app/helpers/JWT.php";

class JWTMiddleware {

    public function handle() {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => "Token não enviado."
            ]);
            exit;
        }

        $authHeader = $headers['Authorization'];

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