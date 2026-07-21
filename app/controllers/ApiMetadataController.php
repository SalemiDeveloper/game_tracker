<?php
// Arquivo responsável pela busca de informações externas.


namespace App\Controllers;

use App\Services\GameMetadataService;

class ApiMetadataController {
    private GameMetadataService $service;

    public function __construct() {
        $this->service = new GameMetadataService();
    }

    public function search() {
        header('Content-Type: application/json');
        $title = $_GET['title'] ?? '';

        if (empty($title)) {
            http_response_code(400);
            echo json_encode([
                'error' => 'O parâmetro "title" é obrigatório.'
            ]);
            return;
        }

        echo json_encode(
            $this->service->findByTitle($title)
        );
    }

    public function show() {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            http_response_code(400);
            echo json_encode([
                'error' => 'ID inválido'
            ]);
            return;
        }

        $game = $this->service->findById($id);

        if (empty($game)) {
            http_response_code(400);
            echo json_encode([
                'error' => 'Jogo não encontrado'
            ]);
            return;
        }

        echo json_encode($game);
    }
}