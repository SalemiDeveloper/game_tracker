<?php

require_once "../app/models/Game.php";
require_once "../app/core/Controller.php";
require_once "../app/core/Validator.php";

class GameController extends Controller{
    
    public function index() {

        $games = (new Game())->all();
        $this->view('games.index', [
            'games' => $games
        ]);
    }

    public function store() {

        $errors = Validator::validate($_POST, [
            'titulo' => ['required'],
            'nota'   => ['required', 'number', 'min:0', 'max:10']
        ]);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;

            header("Location: /games");
            exit;
        }
        
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

        $errors = Validator::validate($_POST, [
            'titulo' => ['required'],
            'nota'   => ['required', 'number', 'min:0', 'max:10']
        ]);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;

            header("Location: /games/edit?id=".$_POST['id']);
            exit;
        }

        (new Game())->update($_POST);

        $_SESSION['success'] = "Jogo atualizado com sucesso!";

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