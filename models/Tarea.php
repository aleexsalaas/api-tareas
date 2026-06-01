<?php

class Tarea{

    private $conn;
    private $table_name = "tareas";

    public function __construct($db){
        $this->conn = $db;
    }

    public function getTodas(){

        $query = "SELECT tareas.titulo, tareas.descripcion, tareas.fecha_limite, tareas.estado, usuarios.email AS email_usuario FROM ". $this->table_name ." INNER JOIN usuarios ON usuarios.id = tareas.usuario_id ORDER BY tareas.fecha_creacion DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function crear($titulo, $descripcion, $fecha_limite, $usuario_id){
        $query = "INSERT INTO ". $this->table_name ."(titulo, descripcion, fecha_limite, usuario_id) VALUES(:titulo, :descripcion, :fecha_limite, :usuario_id)";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([':titulo'=>$titulo, ':descripcion'=>$descripcion, ':fecha_limite'=>$fecha_limite, ':usuario_id'=>$usuario_id]);

    }

    public function borrar($id){
        $query = "DELETE FROM ". $this->table_name ." WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->execute([':id'=>$id]);

        if($stmt->rowCount()> 0){
            return true;
        } else {
            return false;
        }
    }

    public function actualizarEstado($id, $estado){
        $query = "UPDATE ". $this->table_name ." SET estado = :estado WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->execute([':id'=> $id, ':estado'=>$estado]);

        if($stmt->rowCount()> 0){
            return true;
        } else {
            return false;
        }
    }
}