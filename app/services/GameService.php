<?php
require_once "../app/models/Game.php";
require_once "../app/core/Validator.php";

class GameService {
    private $model;

    public function __construct() {
        $this->model = new Game();
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

    public function update($data) {
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

    public function all() {
        return $this->model->all();
    }

    public function find($id) {
        return $this->model->find($id);
    }
}
?>