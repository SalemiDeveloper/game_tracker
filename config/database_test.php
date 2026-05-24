<?php

class TestDatabase {
    public static function connect() {

        $host     = $_ENV['DB_HOST'];
        $db       = $_ENV['DB_NAME'];
        $user     = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];

        $pdo = new PDO ("mysql:host={$host};dbname={$db}", $user, $password);
        //$pdo = new PDO ("mysql:host=localhost;dbname=game_tracker_test", "root", "");

        $pdo->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC
        );

        return $pdo;
    }
}

?>