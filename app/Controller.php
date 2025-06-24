<?php

class Controller {
    protected function view($view_name="", $data=[]) {
        require_once "../views/$view_name.php";
    }
}