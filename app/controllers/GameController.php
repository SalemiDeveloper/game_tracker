<?php

require_once "../app/models/Game.php";
require_once "../app/core/Controller.php";
require_once "../app/core/Validator.php";
require_once "../app/services/GameService.php";

class GameController extends Controller{
    
    public function index() {

        $games = (new Game())->all();
        $this->view('games.index', [
            'games' => $games
        ]);
    }

    public function store() {

        if (!isset($_POST['csrf']) || $_POST['csrf'] !== $_SESSION['csrf']) {
            die('CSRF token inválido.');
        }

        $service = new GameService();

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
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: /games");
            exit;
        }

        $game = (new Game())->find($id);

        if (!$game) {
            header("Location: /games");
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

        $service = new GameService();

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

        $service = new GameService();
        $service->delete($_POST['id']);

        header('Location: /games');
        exit;
    }
}

?>