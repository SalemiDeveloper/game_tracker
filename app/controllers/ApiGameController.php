<?php

require_once "../app/services/GameService.php";

class ApiGameController {

    public function index() {
        $service = new GameService();

        $userId = $_SERVER['user']['id'];
        $games = $service->all($userId);

        header('Content-Type: application/json');

        echo json_encode($games);
    }

    public function store() {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);
        $input['user_id'] = $_SERVER['user']['id'];

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

    public function show($id) {
        header('Content-Type: application/json');

        $userId  = $_SERVER['user']['id'];
        $service = new GameService();        
        $game    = $service->findOwned($id, $userId);

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

        $service = new GameService();

        $game = $service->findOwned($id, $userId);

        if (!$game) {

            http_response_code(403);
            echo json_encode([
                'success' => false,
                'message' => 'Acesso negado ou jogo não encontrado.'
            ]);

            return;
        }

        $result = $service->update($input);

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

        $service = new GameService();

        $game = $service->findOwned($id, $userId);

        if (!$game) {

            http_response_code(403);
            echo json_encode([
                'success' => false,
                'message' => 'Acesso negado ou jogo não encontrado.'
            ]);

            return;
        }

        $result = $service->delete($id);

        if (!$result['success']) {
            http_response_code(404);
            echo json_encode($result);

            return;
        }

        echo json_encode([
            'success' => true
        ]);
    }
}

?>