<?php
namespace App\Services;

use App\Models\Game;
use App\Core\Validator;

class GameService {
    private $model;

    public function __construct($db) {
        $this->model = new Game($db);
    }

    public function create($data) {
        $errors = Validator::validate($data,  [
            'titulo'     => ['required'],
            'nota'       => ['required', 'number', 'min:0', 'max:10'],
            'plataforma' => ['required'],
            'genero'     => ['required']
        ]);

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors'  => $errors,
                'old'     => $data
            ];
        }

        // $this->model->create($data);
        $gameId = $this->model->create($data);
    
        return [
            'success' => true,
            'id'      => $gameId
        ];
    }

    public function update(array $data) {
        $errors = Validator::validate($data, [
            'titulo'     => ['required'],
            'nota'       => ['required', 'number', 'min:0', 'max:10'],
            'plataforma' => ['required', 'string'],
            'genero'     => ['required', 'string'],
            'ano_lancamento' => ['number'],
            'horas_jogadas'  => ['number', 'min:0']
        ]);

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors'  => $errors, 
                'old'     => $data
            ];
        }

        $this->model->update($data);

        return ['success' => true];
    }

    public function delete($id) {

        $game = $this->model->find($id);

        if (!$game) {
            return [
                'success' => false,
                'message' => 'Jogo não encontrado'
            ];
        }

        $this->model->delete($id);

        return [
            'success' => true
        ];
    }

    public function all($userId, $filters = []) {
        return $this->model->all($userId, $filters);
    }

    public function find($id) {
        return $this->model->find($id);
    }

    public function findOwned($id, $userId) {
        return $this->model->findOwned($id, $userId);
    }

    public function stats($userId) {
        return $this->model->stats($userId);
    }

    public function highlights($userId) {
        return $this->model->highlights($userId);
    }

    public function getUserPlatforms($userId) {
        return $this->model->getUserPlatforms($userId);
    }

    public function getUserGeneros($userId) {
        return $this->model->getUserGeneros($userId);
    }

    public function getStatusOptions() {
        return $this->model->getStatusOptions();
    }

    public function getPlatformOptions() {
        return $this->model->getPlatformOptions();
    }

    public function getGenreOptions() {
        return $this->model->getGenreOptions();
    }

    public function getDashboardData(array $games): array {
        $totalGames = count($games);

        $jogando = 0;
        $zerado = 0;
        $porcento = 0;
        $platina = 0;
        $backlog = 0;
        $dropado = 0;
        $totalHours = 0;
        $ratingSum = 0;

        foreach($games as $game) {
            switch ($game['status']) {
                case 'backlog':
                    $backlog++;
                    break;

                case 'jogando':
                    $jogando++;
                    break;

                case 'zerado':
                    $zerado++;
                    break;

                case '100_porcento':
                    $porcento++;
                    break;

                case 'platina':
                    $platina++;
                    break;

                case 'dropado':
                    $dropado++;
                    break;
            }

            $ratingSum += (float) $game['nota'];
            $totalHours += (int) ($game['horas_jogadas'] ?? 0);
        }

        return [
            'totalGames' => $totalGames,
            'backlog' => $backlog,
            'jogando' => $jogando,
            'zerado' => $zerado,
            '100_porcento' => $porcento,
            'platina' => $platina,
            'dropado' => $dropado,
            'totalHours' => $totalHours,
            'averageRating' => $totalGames ? round($ratingSum / $totalGames, 1) : 0
        ];
    }
}
?>