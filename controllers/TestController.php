<?php

class TestController {
    public function show() {
        $this->view("test", [
            "name" => "mbarek",
        ]);
    }

    public function delete() {
        echo "TestController::delete";
    }

    private function view($view_name = "", $date = []) {
        require_once "../views/$view_name.php";
    }
}