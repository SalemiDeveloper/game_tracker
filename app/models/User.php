<?php 

//require_once "../config/database.php";
require_once "../app/core/Model.php";

class User extends Model{

    public function create($data) {

        $stmt = $this->db->prepare("
        INSERT INTO users (name, email, password)
        VALUES (:name, :email, :password)
        ");

        return $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);
    }

    public function findByEmail($email) {

        $stmt = $this->db->prepare("
        SELECT * FROM users
        WHERE email = :email
        ");

        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetch();
    }
}