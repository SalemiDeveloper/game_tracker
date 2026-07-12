<?php

namespace App\Controllers;

use App\Models\Game;
//require_once "../app/models/Game.php";
use App\Core\Controller;
use App\Core\Validator;
use App\Services\GameService;
//require_once "../config/database.php";
require_once __DIR__ . '/../../config/database.php';

class GameController extends Controller{

    private $db, $service;

    public function __construct() {
        $this->db = \Database::connect();
        $this->service = new GameService($this->db);
    }
    
    public function index() {

        $userId = $_SESSION['user']['id'];

        $filters = [];
        $filters['q'] = trim($_GET['search'] ?? '');
        $filters['status'] = $_GET['status'] ?? '';
        $filters['sort'] = $_GET['sort'] ?? '';

        $games  = $this->service->all($userId, $filters);
        $stats  = $this->service->stats($userId);
        $highlights = $this->service->highlights($userId);

        $this->view('games.index', [
            'games'  => $games,
            'stats'  => $stats,
            'highlights' => $highlights,
            'filters' => $filters
        ]);
    }

    public function create() {
        $this->view('games.create', [
            'statusOptions' => $this->service->getStatusOptions(),
            'platformOptions' => $this->service->getPlatformOptions(),
            'genreOptions' => $this->service->getGenreOptions()
            ]);
    }

    public function store() {

        if (!isset($_POST['csrf']) || $_POST['csrf'] !== $_SESSION['csrf']) {
            die('CSRF token inválido.');
        }

        $_POST['user_id'] = $_SESSION['user']['id'];
        $result = $this->service->create($_POST);
        if (!$result['success']) {
            $_SESSION['errors'] = $result['errors'];
            $_SESSION['old'] = $result['old'];

            header("Location: /games/create");
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

        $game = $this->service->findOwned($id, $userId);

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
        $game = $this->service->findOwned($_POST['id'], $userId);

        if (!$game) {
            http_response_code(403);
            echo "Acesso Negado";
            exit;
        }

        $result = $this->service->update($_POST);

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
        $game = $this->service->findOwned($_POST['id'], $userId);

        if (!$game) {
            http_response_code(403);
            echo "Acesso Negado";
            exit;
        }

        $this->service->delete($_POST['id']);

        header('Location: /games');
        exit;
    }


}

?>