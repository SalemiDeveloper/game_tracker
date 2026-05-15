<?php

use App\Core\Model;

class Game extends Model{

    public function all($userId) {
        $stmt = $this->db->prepare("
            SELECT * FROM games
            WHERE user_id = :user_id
        ");

        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO games (titulo, nota, user_id)
            VALUES (:titulo, :nota, :user_id)
        ");

        return $stmt->execute([
            'titulo'  => $data['titulo'],
            'nota'    => $data['nota'],
            'user_id' => $data['user_id']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare(
            "DELETE FROM games WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function find($id) {

        $stmt = $this->db->prepare(
            "SELECT * FROM games WHERE id = :id"
        );

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }

    public function findOwned($id, $userId) {

        $stmt = $this->db->prepare("
            SELECT * FROM games
            WHERE id = :id 
            AND user_id = :user_id
        ");

        $stmt->execute([
            'id' => $id, 
            'user_id' => $userId
        ]);

        return $stmt->fetch();
    }

    public function update($data) {

        $stmt = $this->db->prepare("
            UPDATE games
            SET titulo = ?, nota = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['titulo'],
            $data['nota'],
            $data['id']
        ]);
    }
}

?>