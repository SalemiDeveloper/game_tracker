<?php

namespace App\Models;

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
            INSERT INTO games (titulo, nota, user_id
            , plataforma, status, horas_jogadas, review, genero, ano_lancamento
            )
            
            VALUES (:titulo, :nota, :user_id
            , :plataforma, :status, :horas_jogadas, :review, :genero, :ano_lancamento
            )
        ");

        /*
        , plataforma, status, horas_jogadas, review, genero, ano_lancamento
        , :plataforma, :status, :horas_jogadas, :review, :genero, :ano_lancamento
        */

        $stmt->execute([
            'titulo'  => $data['titulo'],
            'nota'    => $data['nota'],
            'user_id' => $data['user_id'],
            'plataforma'     => $data['plataforma'] ?? null,
            'status'         => $data['status'] ?? null,
            'horas_jogadas'  => $data['horas_jogadas'] ?? null,
            'review'         => $data['review'] ?? null,
            'genero'         => $data['genero'] ?? null,
            'ano_lancamento' => $data['ano_lancamento'] ?? null
        ]);

        return (int) $this->db->lastInsertId();
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
            SET titulo = ?, nota = ?, plataforma = ?, status = ?, horas_jogadas = ?, review = ?,
            genero = ?, ano_lancamento = ?, updated_at = ?
            WHERE id = ?
        ");

        /*
        , plataforma = ?, status = ?, horas_jogadas = ?, review = ?,
                genero = ?, ano_lancamento = ?, updated_at = ?
        */

        return $stmt->execute([
            $data['titulo'],
            $data['nota'], 
            $data['plataforma'] ?? null,
            $data['status'] ?? null,
            $data['horas_jogadas'] ?? null,
            $data['review'] ?? null,
            $data['genero'] ?? null,
            $data['ano_lancamento'] ?? null,
            $data['updated_at'] ?? null,
            $data['id']
        ]);
    }
}

?>