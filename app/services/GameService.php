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
            'titulo'  => ['required'],
            'nota'    => ['required', 'number', 'min:0', 'max:10']
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
            'titulo'  => ['required'],
            'nota'    => ['required', 'number', 'min:0', 'max:10']
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

    public function getPlatforms($userId) {
        return $this->model->getPlatforms($userId);
    }

    public function getGeneros($userId) {
        return $this->model->getGeneros($userId);
    }

    public function getStatusOptions() {
        return $this->model->getStatusOptions();
    }
}
?>