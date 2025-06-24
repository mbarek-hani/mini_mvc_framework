<?php

class Controller {
    protected $pdo;
    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=". DBHOST .";dbname=". DBNAME,DBUSER,DBPASS);
        } catch (PDOException $e) {
            die("Failed to connect to db" . $e->getMessage());
        }
    }
    protected function view($view_name="", $data=[]) {
        require_once "../views/$view_name.php";
    }
}