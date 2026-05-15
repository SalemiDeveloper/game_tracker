<?php 

use App\Core\Model;

class RefreshToken extends Model {

    public function create($data) {

        $stmt = $this->db->prepare("
            INSERT INTO refresh_tokens (user_id, token, expires_at)
            VALUES (:user_id, :token, :expires_at)
        ");

        return $stmt->execute([
            'user_id' => $data['user_id'],
            'token'   => $data['token'],
            'expires_at' => $data['expires_at']
        ]);
    }

    public function find($token) {


        $stmt = $this->db->prepare("
            SELECT * FROM refresh_tokens
            WHERE token = :token
        ");

        $stmt->execute([
            'token' => $token
        ]);

        return $stmt->fetch();
    }

    public function deleteExpired() {
         $stmt = $this->db->prepare("
            DELETE FROM refresh_tokens
            WHERE expires_at < NOW()
        ");

        return $stmt->execute();
    }

    public function delete($token) {

        $stmt = $this->db->prepare("
            DELETE FROM refresh_tokens
            WHERE token = :token
        ");

        return $stmt->execute([
            'token' => $token
        ]);
    }
}

?>