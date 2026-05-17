<?php 

use PHPUnit\Framework\TestCase;
use App\Helpers\JWT;

class JWTTest extends TestCase {

    public function testGenerateToken() {
        $token = JWT::generate(['id' => 1]);

        $this->assertNotEmpty($token);
    }

    public function testValidateToken() {
        $token   = JWT::generate(['id' => 1]);
        $payload = JWT::validate($token);

        $this->assertEquals(1, $payload['id']);
    }
}

?>