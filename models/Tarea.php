<?php

class Tarea{

    private $conn;
    private $table_name = "tareas";

    public function __construct($db){
        $this->conn = $db;
    }

    public function getTodas(){

        $query = "SELECT * FROM ". $this->table_name ." ORDER BY fecha_creacion DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;

}
}