<?php

require_once "../config/database.php";

class Game {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function all() {
        return $this->db
        ->query("SELECT * FROM games ORDER BY id DESC")
        ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO games (titulo, nota)
            VALUES (?, ?)
        ");

        return $stmt->execute([
            $data['titulo'],
            $data['nota']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM games WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM games WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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