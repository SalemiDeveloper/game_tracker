<?php 

use PHPUnit\Framework\TestCase;

class ApiAuthTest extends TestCase {

    public function testLoginApi() {

        $url = "http://localhost:8000/api/login";
        $data = [
            'email'    => 'marina@gmail.com',
            'password' => '111222'
        ];

        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            ]
        ];

        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $json     = json_decode($response, true);

        $this->assertArrayHasKey('access_token', $json);
        $this->assertArrayHasKey('refresh_token', $json);
    }

    // public function testEndpointProtegidoSemToken() {

    //     $url = "http://localhost:8000/api/login/games/";

    //     $options = [
    //         'http' => [
    //             'method'  => 'GET',
    //             'ignore_errors' => true
    //         ]
    //     ];

    //     $context  = stream_context_create($options);
    //     $response = file_get_contents($url, false, $context);
    //     $statusCode = $http_response_header[0]; // Variável vem do file_gets_contents();

    //     $this->assertStringContainsString('401', $statusCode);
    // }

    public function testEndpointProtegidoSemToken() {
        
        $url = 'http://localhost:8000/api/games';

        $options = [
            'http' => [
                'method' => 'GET',
                'header' =>
                    "Accept: application/json\r\n",
                'ignore_errors' => true
            ]
        ];

        $context    = stream_context_create($options);
        $response   = file_get_contents($url, false, $context);
        $statusLine = $http_response_header[0];

        $this->assertStringContainsString('401', $statusLine);
        $this->assertStringContainsString('Token', $response);
    }


    // login real -> gera JWT -> Authorization: Bearer -> middleware aceita -> endpoint protegido funciona -> 200 ok
    //JWT válido -> middleware aceita -> controller executa
    public function testEndPointProtegidoComToken() {

        // login
        $loginData = [
            'email' => 'marina@gmail.com',
            'password' => '111222'
        ];

        $loginOptions = [
            'http' => [
                'header' => "Content-Type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($loginData)
            ]
        ];

        $loginContext = stream_context_create($loginOptions);
        $loginResponse = file_get_contents('http://localhost:8000/api/login', false, $loginContext);
        $loginJson = json_decode($loginResponse, true);
        $token = $loginJson['access_token'];

        // request protegida
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => "Authorization: Bearer {$token}\r\n" . "Accept: application/json\r\n",
                'ignore_errors' => true
            ]
        ];

        $context = stream_context_create($options);
        file_get_contents('http://localhost:8000/api/games', false, $context);

        $statusLine = $http_response_header[0];

        $this->assertStringContainsString('200', $statusLine);
    }


    // Bearer fake -> JWT middleware -> 401
    public function testEndpointProtegidoComTokenInvalido() {
        $token = 'token_fake';

        $options = [
            'http' => [
                'method' => 'GET',
                'header' =>
                    "Authorization: Bearer {$token}\r\n" .
                    "Accept: application/json\r\n",
                'ignore_errors' => true
            ]
        ];

        $context = stream_context_create($options);

        $response = file_get_contents('http://localhost:8000/api/games', false, $context);
        $statusLine = $http_response_header[0];

        $this->assertStringContainsString('401', $statusLine);
        $data = json_decode($response, true);
        $this->assertStringContainsString('token não enviado', strtolower($data['message']));
    }



    // JWT expirado -> middleware rejeita -> 401
    public function testEndpointProtegidoComTokenExpirado() {
        $payload = [
            'id' => 1,
            'email' => 'teste@test.com',
            'iat' => time() - 3600,
            'exp' => time() - 10
        ];

        $token = \App\Helpers\JWT::generate($payload);

        $options = [
            'http' => [
                'method' => 'GET',
                'header' =>
                    "Authorization: Bearer {$token}\r\n" .
                    "Accept: application/json\r\n",
                'ignore_errors' => true
            ]
        ];

        $context = stream_context_create($options);
        file_get_contents('http://localhost:8000/api/games', false, $context);
        $statusLine = $http_response_header[0];

        $this->assertStringContainsString('401', $statusLine);
    }


    // Valida: login real -> refresh token real -> refresh endpoint -> novo jwt
    public function testRefreshTokenValido() {
        // LOGIN
        $loginData = [
            'email' => 'marina@gmail.com',
            'password' => '111222'
        ];

        $loginOptions = [
            'http' => [
                'header' =>
                    "Content-Type: application/json\r\n",
                'method' => 'POST',
                'content' =>
                    json_encode($loginData)
            ]
        ];

        $loginContext = stream_context_create($loginOptions);
        $loginResponse = file_get_contents('http://localhost:8000/api/login', false, $loginContext);
        $loginJson = json_decode($loginResponse, true);
        $refreshToken = $loginJson['refresh_token'];

        // REFRESH
        $refreshData = ['refresh_token' => $refreshToken];

        $refreshOptions = [
            'http' => [
                'header' =>
                    "Content-Type: application/json\r\n",
                'method' => 'POST',
                'content' =>
                    json_encode($refreshData),
                'ignore_errors' => true
            ]
        ];

        $refreshContext = stream_context_create($refreshOptions);
        $refreshResponse = file_get_contents('http://localhost:8000/api/refresh', false, $refreshContext);
        $statusLine = $http_response_header[0];
        $json = json_decode($refreshResponse, true);

        $this->assertStringContainsString('200', $statusLine);
        $this->assertArrayHasKey('access_token', $json);
    }


    // O que valida: refresh fake -> controller -> RefreshToken::find() -> não encontrou -> 401
    public function testRefreshTokenInvalido() {
        $data = [
            'refresh_token' =>
                'token_fake'
        ];

        $options = [
            'http' => [
                'header' =>
                    "Content-Type: application/json\r\n",
                'method' => 'POST',
                'content' =>
                    json_encode($data),
                'ignore_errors' => true
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents('http://localhost:8000/api/refresh', false, $context);

        $statusLine = $http_response_header[0];

        $json = json_decode($response, true);

        $this->assertStringContainsString('401', $statusLine);
        $this->assertFalse($json['success']);
    }
}

?>