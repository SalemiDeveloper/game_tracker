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
            'titulo' => ['required'],
            'nota'   => ['required', 'number', 'min:0', 'max:10']
        ]);

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors'  => $errors,
                'old'     => $data
            ];
        }

        $this->model->create($data);
    
        return ['success' => true];
    }

    public function update(array $data) {
        $errors = Validator::validate($data, [
            'titulo' => ['required'],
            'nota'   => ['required', 'number', 'min:0', 'max:10']
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

    public function all($userId) {
        return $this->model->all($userId);
    }

    public function find($id) {
        return $this->model->find($id);
    }

    public function findOwned($id, $userId) {
        return $this->model->findOwned($id, $userId);
    }
}
?>