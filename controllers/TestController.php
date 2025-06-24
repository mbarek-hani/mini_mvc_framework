<?php

require_once "../app/Controller.php";
require_once "../models/User.php";

class TestController extends Controller{
    public function show() {
        $user_model = new User($this->pdo);

        $users = $user_model->get_all();

        $this->view("test", [
            "users" => $users,
        ]);
    }

    public function add() {
        $user_model = new User($this->pdo);
        $user_model->store([
            "username" => "haniTest",
            "first_name" => "testhani",
            "last_name" => "testhani123",
            "email" => "hani@test.mb"
        ]);
        echo "done";
    }

    public function update() {
        $user_model = new User($this->pdo);
        $user_model->update(101, [
            "username" => "hanihani12",
            "first_name" => "mbarek1564",
            "last_name"=> "hani1564",
            "email"=> "mbare@hani.com"
        ]);
        echo "done";
    }

    public function delete($id) {
        $user_model = new User($this->pdo);
        $user_model->delete($id);
        header("location: /test");
    }
}