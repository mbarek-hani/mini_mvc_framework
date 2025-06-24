<?php

require_once "../app/Controller.php";

class TestController extends Controller{
    public function show() {
        $this->view("test", [
            "name" => "mbarek",
        ]);
    }

    public function delete() {
        echo "TestController::delete";
    }
}