<?php

namespace App\Models;

use App\Core\Model;
use App\Helpers\StatusHelper;

class Game extends Model{

    public function all($userId, $filters = []) {
        $sql = "SELECT * 
                FROM games 
                WHERE user_id = :user_id ";

        $params = ['user_id' => $userId];

        //filtro status
        if (!empty($filters['status'])) {
            $sql .= "AND status = :status ";
            $params['status'] = $filters['status'];
        }

        // filtro plataforma
        if (!empty($filters['plataforma'])) {
            $sql .= "AND plataforma = :plataforma ";
            $params['plataforma'] = $filters['plataforma'];
        }

        // filtro gênero
        if (!empty($filters['genero'])) {
            $sql .= "AND genero = :genero ";
            $params['genero'] = $filters['genero'];
        }

        // filtro título
        if (!empty($filters['q'])) {
            $sql .= "AND titulo LIKE :titulo ";
            $params['titulo'] = "%".$filters['q']."%";
        }


        // ordenação
        $allowedSorts = ['nota', 'updated_at', 'ano_lancamento', 'titulo'];

        // evitando códigos maliciosos pelo SQL.
        if (!empty($filters['sort']) && in_array($filters['sort'], $allowedSorts)) {
            $sql .= " ORDER BY ". $filters['sort'] ." DESC";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO games 
                (titulo, nota, user_id, 
                plataforma, status, horas_jogadas, 
                review, genero, ano_lancamento)
            
            VALUES 
                (:titulo, :nota, :user_id, 
                :plataforma, :status, :horas_jogadas, 
                :review, :genero, :ano_lancamento)
        ");

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
            genero = ?, ano_lancamento = ?, updated_at = NOW()
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['titulo'],
            $data['nota'], 
            $data['plataforma'] ?? null,
            $data['status'] ?? null,
            $data['horas_jogadas'] ?? null,
            $data['review'] ?? null,
            $data['genero'] ?? null,
            $data['ano_lancamento'] ?? null,
            $data['id']
        ]);
    }

    public function stats($userId) {
        $stmt = $this->db->prepare("
            SELECT 
                COUNT(*) as total_games,
                SUM(CASE WHEN status = 'jogando' 
                         THEN 1 
                         ELSE 0
                         END) as jogando,
                SUM(CASE WHEN status IN ('zerado', '100_porcento')
                         THEN 1
                         ELSE 0
                         END) as zerados,
                SUM(CASE WHEN status = 'platinei'
                         THEN 1
                         ELSE 0
                         END) as platinados,
                SUM(CASE WHEN status = 'dropado'
                         THEN 1
                         ELSE 0
                        END) as 'dropados',
                COALESCE(SUM(horas_jogadas),0) as horas_total,
                ROUND(AVG(nota), 1) as nota_media
            FROM games 
            WHERE user_id = :user_id
        ");

        $stmt->execute(['user_id' => $userId]);

        $stats = $stmt->fetch();

        $stats['total_games'] = (int) $stats['total_games'];
        $stats['jogando']     = (int) $stats['jogando'];
        $stats['zerados']     = (int) $stats['zerados'];
        $stats['platinados']  = (int) $stats['platinados'];
        $stats['dropados'] = (int) $stats['dropados'];
        $stats['horas_total'] = (float) $stats['horas_total'];
        $stats['nota_media']  = (float) ($stats['nota_media'] ?? 0);

        return $stats;
    }

    public function getPlatforms($userId) {
        $stmt = $this->db->prepare("
            SELECT DISTINCT plataforma
            FROM games
            WHERE user_id = :user_id
            AND plataforma IS NOT NULL
            AND plataforma != ''
            ORDER BY plataforma ASC
        ");

        $stmt->execute(['user_id' => $userId]);

        return array_column($stmt->fetchAll(), 'plataforma');
    }

    public function getGeneros($userId) {
        $stmt = $this->db->prepare("
            SELECT DISTINCT genero
            FROM games
            WHERE user_id = :user_id
            AND genero IS NOT NULL
            AND genero != ''
            ORDER BY genero ASC
        ");

        $stmt->execute(['user_id' => $userId]);

        return array_column($stmt->fetchAll(), 'genero');
    }

    public function getStatusOptions() {
        return StatusHelper::options();
    }
}

?>