<?php

require_once "../app/models/Game.php";
require_once "../app/core/Controller.php";

class GameController extends Controller{
    
    public function index() {

        $games = (new Game())->all();
        $this->view('games.index', [
            'games' => $games
        ]);
    }

    public function store() {
        
        (new Game())->create($_POST);

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

        (new Game())->update($_POST);

        header("Location: /games");
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? null;

        if ($id) {
            (new Game())->delete($id);
        }

        header("Location: /games");
        exit;
    }
}

?>