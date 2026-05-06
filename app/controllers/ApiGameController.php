<?php

require_once "../app/services/GameService.php";

class ApiGameController {

    public function index() {
        $service = new GameService();

        $games = $service->all();

        header('Content-Type: application/json');

        echo json_encode($games);
    }

    public function store() {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        $service = new GameService();

        $result = $service->create($input);

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
            'success' => true
        ]);
    }
}

?>