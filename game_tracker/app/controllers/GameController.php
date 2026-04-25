<?php

class GameController {
    
    public function index() {

        $games = $_SESSION['games'] ?? [];

        require "../app/views/games/index.php";
    }

    public function store() {
        $game = [
            "id"     => uniqid(),
            "titulo" => $_POST['titulo'] ,
            "nota"   => $_POST['nota']
        ];

        // aqui vai criar array caso não exista
        if (!isset($_SESSION['games'])) {
            $_SESSION['games'] = [];
        }

        // adicionando jogo
        $_SESSION['games'][] = $game;

        header("Location: /games");
        exit;
    }

    public function edit() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: /games");
            exit;
        }

        $games = $_SESSION['games'] ?? [];
        $game = null;

        foreach ($games as $g) {
            if ($g['id'] === $id) {
                $game = $g;
                break;
            }
        }

        if (!$game) {
            header("Location: /games");
            exit;
        }

        require "../app/views/games/edit.php";
    }

    public function update() {

        //die(var_dump($_SESSION));
        $id = $_POST['id'];

        foreach($_SESSION['games'] as &$game) {
            if ($game['id'] === $id) {
                $game['titulo'] = $_POST['titulo'];
                $game['nota']   = $_POST['nota'];
                //die($game['nota'].' '.$_POST['nota']);
                break;
            }
        }

        unset($game);

        header("Location: /games");
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: /games");
            exit;
        }

        $_SESSION['games'] = array_filter($_SESSION['games'], function($game) use ($id) {
            return $game['id'] !== $id;
        });

        header("Location: /games");
        exit;
    }
}

?>