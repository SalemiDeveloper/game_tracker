<?php

require_once "../app/services/GameService.php";

class ApiGameController {

    public function index() {
        $service = new GameService();

        $games = $service->all();

        header('Content-Type: application/json');

        echo json_encode($games);
    }
}

?>