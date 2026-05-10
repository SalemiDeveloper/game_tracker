<?php

class Database {
    public static function connect() {
        $pdo = new PDO ("mysql:host=localhost;dbname=game_tracker", "root", "");

        $pdo->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC
        );

        return $pdo;
    }
}

?>