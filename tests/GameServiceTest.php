<?php 

use PHPUnit\Framework\TestCase;
use App\Services\GameService;

require_once __DIR__ ."/../config/database_test.php";

class GameServiceTest extends TestCase {

    private $db, $gameService, $userId;

    protected function setUp(): void {
        $this->db = TestDatabase::connect();

        // limpando a tabela games
        $this->db->exec("DELETE FROM games");
        // inicia transação
        $this->db->beginTransaction();
        $this->db->exec("
            INSERT INTO users (name, email, password)
            VALUES ('Teste', 'teste2@test.com', '123456')
        ");

        $this->userId = $this->db->lastInsertId();
        $this->gameService = new GameService($this->db);
    }

    protected function tearDown(): void    {
        // desfaz tudo que aconteceu no teste
        if ($this->db->inTransaction()) {
            $this->db->rollBack();
        }
    }

    public function testCreateGameValido() {
        $result = $this->gameService->create([
            'titulo'  => 'Batman',
            'nota'    => '10',
            'user_id' => $this->userId
        ]);

        $this->assertTrue($result['success']);
    }

    public function testCreateGameInvalido() {
        $result = $this->gameService->create([
            'titulo'  => '',
            'nota'    => 15,
            'user_id' => $this->userId
        ]);

        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('titulo', $result['errors']);
        $this->assertArrayHasKey('nota', $result['errors']);
    }

    public function testFindGame() {
        // criando jogo no banco de dados
        $stmt = $this->db->prepare("
            INSERT INTO games (titulo, nota, user_id)
            VALUES (:titulo, :nota, :user_id)
        ");

        $stmt->execute([
            'titulo'  => 'testFindGame',
            'nota'    => 10,
            'user_id' => $this->userId
        ]);

        $gameId = $this->db->lastInsertId();
        $game = $this->gameService->find($gameId);

        $this->assertEquals('testFindGame', $game['titulo']);
        $this->assertEquals(10, $game['nota']);
    }

    public function testUpdateGame()
{
        // cria jogo
        $stmt = $this->db->prepare("
        INSERT INTO games (titulo, nota, user_id)
        VALUES (:titulo, :nota, :user_id)
        ");

        $stmt->execute([
            'titulo' => 'testUpdateGame',
            'nota' => 10,
            'user_id' => $this->userId
        ]);

        $gameId = $this->db->lastInsertId();

        // atualiza jogo
        $result = $this->gameService->update(
            [
                'id' => $gameId,
                'titulo' => 'God of War',
                'nota' => 9,
                'user_id' => $this->userId
            ]
        );

        // busca jogo atualizado
        $game = $this->gameService->find($gameId);

        $this->assertTrue($result['success']);
        $this->assertEquals('God of War', $game['titulo']);
        $this->assertEquals(9, $game['nota']);
    }

    public function testDeleteGame() {
        // cria jogo
        $stmt = $this->db->prepare("
            INSERT INTO games (titulo, nota, user_id)
            VALUES (:titulo, :nota, :user_id)
        ");

        $stmt->execute([
            'titulo' => 'testDeleteGame',
            'nota' => 10,
            'user_id' => $this->userId
        ]);

        $gameId = $this->db->lastInsertId();

        // deleta
        $this->gameService->delete($gameId);
        // tenta buscar
        $game = $this->gameService->find($gameId);
        $this->assertFalse($game);
    }
}

?>