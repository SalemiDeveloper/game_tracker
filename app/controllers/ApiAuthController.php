<?php

require_once "../app/services/AuthService.php";
require_once "../app/helpers/JWT.php";

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

        unset($_SESSION['user']);

        echo json_encode([
            'token' => $token
        ]);
    }
}

?>