<?php

namespace App\Controllers;

use App\Services\GameService;
//require_once "../config/database.php";
require_once __DIR__ . '/../../config/database.php';

class ApiGameController {

    private $db, $service;

    public function __construct() {
        $this->db = \Database::connect();
        $this->service = new GameService($this->db);
    }

    public function index() {

        $userId = $_SERVER['user']['id'];

        $filters = [
            'status'     => $_GET['status']     ?? null,
            'plataforma' => $_GET['plataforma'] ?? null,
            'genero'     => $_GET['genero']     ?? null,
            'q'          => $_GET['q']          ?? null,
            'sort'       => $_GET['sort']       ?? null
        ];

        $games = $this->service->all($userId, $filters);

        header('Content-Type: application/json');

        echo json_encode($games);
    }

    public function store() {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);
        $input['user_id'] = $_SERVER['user']['id'];

        $result = $this->service->create($input);

        if (!$result['success']) {
            http_response_code(422);

            echo json_encode([
                'success' => false,
                'errors'  => $result['errors']
            ]);

            return;
        }

        http_response_code(201);

        echo json_encode([
            'success' => true,
            'id'      => $result['id']
        ]);
    }

    public function show($id) {
        header('Content-Type: application/json');

        $userId  = $_SERVER['user']['id'];   
        $game    = $this->service->findOwned($id, $userId);

        if (!$game) {
            http_response_code(403);
            echo json_encode([
                'success' => false,
                'message' => 'Acesso negado'
            ]);

            return;
        }

        echo json_encode($game);
    }

    public function update($id) {
        header('Content-Type: application/json');

        $userId = $_SERVER['user']['id'];

        $input = json_decode(file_get_contents('php://input'), true);
        $input['id'] = $id;

        $game = $this->service->findOwned($id, $userId);

        if (!$game) {

            http_response_code(403);
            echo json_encode([
                'success' => false,
                'message' => 'Acesso negado ou jogo não encontrado.'
            ]);

            return;
        }

        $result = $this->service->update($input);

        if (!$result['success']) {
            http_response_code(422);

            echo json_encode([
                'success' => false,
                'errors'  => $result['errors']
            ]);

            return;
        }

        echo json_encode([
            'success' => true
        ]);
    }

    public function destroy($id) {
        header('Content-Type: application/json');

        $userId = $_SERVER['user']['id'];

        $game = $this->service->findOwned($id, $userId);

        if (!$game) {

            http_response_code(403);
            echo json_encode([
                'success' => false,
                'message' => 'Acesso negado ou jogo não encontrado.'
            ]);

            return;
        }

        $result = $this->service->delete($id);

        if (!$result['success']) {
            http_response_code(404);
            echo json_encode($result);

            return;
        }

        echo json_encode([
            'success' => true
        ]);
    }

    public function dashboard() {
        header('Content-Type: application/json');

        $userId = $_SERVER['user']['id'];

        $stats = $this->service->stats($userId);

        echo json_encode($stats);
    }

    public function platforms() {
        header('Content-Type: application/json');

        $userId = $_SERVER['user']['id'];
        $plataforms = $this->service->getPlatforms($userId);

        echo json_encode($plataforms);
    }

    public function generos() {
        header('Content-Type: application/json');

        $userId = $_SERVER['user']['id'];
        $generos = $this->service->getGeneros($userId);

        echo json_encode($generos);
    }

    public function statusOptions() {
        header('Content-Type: application/json');

        $statusOptions = $this->service->getStatusOptions();
        echo json_encode($statusOptions);
    }
}

?>