<?php

namespace App\Controllers;

require_once "../app/models/Game.php";
use App\Core\Controller;
use App\Core\Validator;
use App\Services\GameService;

class GameController extends Controller{
    
    public function index() {

        $userId = $_SESSION['user']['id'];
        $games = (new \Game())->all($userId);
        $this->view('games.index', [
            'games' => $games
        ]);
    }

    public function store() {

        if (!isset($_POST['csrf']) || $_POST['csrf'] !== $_SESSION['csrf']) {
            die('CSRF token inválido.');
        }

        $service = new GameService();

        $_POST['user_id'] = $_SESSION['user']['id'];
        $result = $service->create($_POST);

        if (!$result['success']) {
            $_SESSION['errors'] = $result['errors'];
            $_SESSION['old'] = $result['old'];

            header("Location: /games");
            exit;
        }

        $_SESSION['success'] = "Jogo criado com sucesso!";

        header("Location: /games");
        exit;
    }

    public function edit() {
        $userId = $_SESSION['user']['id'];
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: /games");
            exit;
        }

        $game = (new \Game())->findOwned($id, $userId);

        if (!$game) {
            http_response_code(403);
            echo "Acesso negado";
            exit;
        }

        $this->view('games.edit', [
            'game' => $game
        ]);
    }

    public function update() {

        if (!isset($_POST['csrf']) || $_POST['csrf'] !== $_SESSION['csrf']) {
            die('CSRF token inválido.');
        }
        
        $userId = $_SESSION['user']['id'];
        $service = new GameService();
        $game = $service->findOwned($_POST['id'], $userId);

        if (!$game) {
            http_response_code(403);
            echo "Acesso Negado";
            exit;
        }

        $result = $service->update($_POST);

        if (!$result['success']) {
            $_SESSION['errors'] = $result['errors'];
            $_SESSION['old'] = $result['old'];

            header("Location: /games/edit?id=".$_POST['id']);
            exit;
        }

        $_SESSION['success'] = "Jogo atualizado com sucesso!";

        header("Location: /games");
        exit;
    }

    public function delete() {

        $userId = $_SESSION['user']['id'];
        $service = new GameService();
        $game = $service->findOwned($_POST['id'], $userId);

        if (!$game) {
            http_response_code(403);
            echo "Acesso Negado";
            exit;
        }

        $service->delete($_POST['id']);

        header('Location: /games');
        exit;
    }
}

?>