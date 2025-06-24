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
        $user_model->update(101, []);
        $this->session->flashSuccess("user with id 101 was updated successfully");
        header("location: /test");

    }

    public function delete($id) {
        $user_model = new User($this->pdo);
        $user_model->delete($id);
        $this->session->flashSuccess("user with id $id was deleted successfully");
        header("location: /test");
    }
}