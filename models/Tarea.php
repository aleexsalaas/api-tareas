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

    public function crear($titulo, $descripcion, $fecha_limite){
        $query = "INSERT INTO ". $this->table_name ."(titulo, descripcion, fecha_limite) VALUES(:titulo, :descripcion, :fecha_limite)";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([':titulo'=>$titulo, ':descripcion'=>$descripcion, ':fecha_limite'=>$fecha_limite]);

    }

    public function borrar($id){
        $query = "DELETE FROM ". $this->table_name ." WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([':id'=>$id]);
    }
}