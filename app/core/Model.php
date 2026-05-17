<?php

namespace App\Core;

require_once __DIR__ . "/../../config/database.php";
//require_once __DIR__ . "/../../config/database_test.php";

class Model {

    protected $db;

    public function __construct($db = null) {
        $this->db = $db ?? \Database::connect();
    }
}

?>