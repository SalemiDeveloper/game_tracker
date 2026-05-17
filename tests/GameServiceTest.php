<?php 

use PHPUnit\Framework\TestCase;
use App\Services\GameService;

require_once __DIR__ ."/../config/database_test.php";

class GameServiceTest extends TestCase {

    private $db, $gameService;

    protected function setUp(): void {
        $this->db = TestDatabase::connect();

        //limpando a tabela games
        $this->db->exec("DELETE FROM games");

        $this->gameService = new GameService($this->db);
    }

    public function testCreateGameValido() {
        $result = $this->gameService->create([
            'titulo' => 'Batman',
            'nota'   => '10'
        ]);

        $this->assertTrue($result['success']);
    }
}

?>