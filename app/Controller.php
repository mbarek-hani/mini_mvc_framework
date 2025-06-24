<?php

require_once "Session.php";
class Controller {
    protected $pdo;
    protected $session;
    public function __construct() {
        $this->session = new Session();
        try {
            $this->pdo = new PDO("mysql:host=". DBHOST .";dbname=". DBNAME,DBUSER,DBPASS);
        } catch (PDOException $e) {
            die("Failed to connect to db" . $e->getMessage());
        }
    }
    protected function view($view_name="", $data=[]) {
        $data['session'] = $this->session;
        
        extract($data);
        require_once "../views/$view_name.php";
    }
}