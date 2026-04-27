<?php

require_once "../config/database.php";

class Model {

    protected $db;

    public function __construct() {
        $this->db = Database::connect();
    }
}

?>