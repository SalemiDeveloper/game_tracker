<?php 

use App\Services\AuthService;
use PHPUnit\Framework\TestCase;

require_once __DIR__."/../config/database_test.php";

class AuthServiceTest extends TestCase {

    private $db, $auth;

    protected function setUp(): void {
        $this->db = TestDatabase::connect();

        // limpando a tabela users antes de cada teste
        $this->db->exec("DELETE FROM users");
        
        $this->auth = new AuthService($this->db);
    }

    public function testRegisterUsuario() {
        $result = $this->auth->register([
            'name'     => 'Pedro',
            'email'    => 'pedro@gmail.com',
            'password' => '123456'
        ]);

        $this->assertTrue($result['success']);
    }

    public function testLoginValido() {
        // aqui crio usuário no banco de dados para testar
        $this->auth->register([
            'name'     => 'Grilo',
            'email'    => 'grilo@gmail.com',
            'password' => 'grilo123'
        ]);

        $result = $this->auth->login([
            'email'    => 'grilo@gmail.com',
            'password' => 'grilo123'
        ]);

        $this->assertTrue($result['success']);
    }

    public function testLoginSenhaInvalida() {
        $this->auth->register([
            'name'     => 'Grilo',
            'email'    => 'grilo@gmail.com',
            'password' => 'grilo123'
        ]);

        $result = $this->auth->login([
            'email'    => 'grilo@gmail.com',
            'password' => 'senha_errada123'
        ]);

        $this->assertFalse($result['success']);
    }

    public function testLoginEmailInexistente() {
        $result = $this->auth->login([
            'email'    => 'naoexiste@gmail.com',
            'password' => '123456'
        ]);

        $this->assertFalse($result['success']);
    }

    public function testRegisterDuplicado() {
        $this->auth->register([
            'name' => 'Pedro',
            'email' => 'pedro@test.com',
            'password' => '123123'
        ]);

        $result = $this->auth->register([
            'name' => 'Pedro 2',
            'email' => 'pedro@test.com',
            'password' => '321321'
        ]);

        $this->assertFalse($result['success']);
    }
}

?>