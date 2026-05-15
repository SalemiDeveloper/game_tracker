<?php 

use PHPUnit\Framework\TestCase;

require_once __DIR__. "/../app/helpers/JWT.php";

class JWTTest extends TestCase {

    public function testGenerateToken() {
        $token = JWT::generate([
            'id' => 1
        ]);

        $this->assertNotEmpty($token);
    }

    public function testValidateToken() {
        $token = JWT::generate([
            'id' => 1
        ]);

        $payload = JWT::validate($token);

        $this->assertEquals(1, $payload['id']);
    }
}

?>