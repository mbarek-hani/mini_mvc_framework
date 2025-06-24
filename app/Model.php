<?php

class Model {
    protected $pdo;
    protected $table = "";

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function get_all() {
        $stmt = $this->pdo->query("select * from $this->table");
        $models = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $models;
    }

    public function get_by_id($id) {
        $stmt = $this->pdo->prepare("select * from $this->table where id=?");
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $model = $stmt->fetch(PDO::FETCH_OBJ);
        return $model;
    }

    public function store($data) {
        $cols = implode(",", array_keys($data));
        $place_holders = implode(",", array_fill(0, count($data), "?"));

        $stmt = $this->pdo->prepare("insert into $this->table($cols) values($place_holders)");

        $i = 1;
        foreach($data as $key => $value) {
            $stmt->bindValue($i, $value);
            $i++;
        }

        $stmt->execute();
    }
    
    public function update($id, $data) {
        $set_clauses = array_map(fn($key) => "$key = ?", array_keys(array: $data));
        $set_string = implode(separator: ", ", array: $set_clauses);
        $stmt = $this->pdo->prepare(query: "update $this->table set $set_string where id = ?");
        
        $i = 1;
        foreach($data as $key => $value) {
            $stmt->bindValue(param: $i, value: $value);
            $i++;
        }
        
        $stmt->bindValue(param: $i, value: $id);
        
        $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("delete from $this->table where id=?");
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }
}