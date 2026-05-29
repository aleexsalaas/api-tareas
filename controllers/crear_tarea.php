<?php

header("Content-Type: application/json");

require 'config/db.php';
require 'models/Tarea.php';

$db_class = new Database();

$db = $db_class->getConnection();

$tarea = new Tarea($db);

$data = json_decode(file_get_contents("php://input"));

if(!isset($data->titulo)){
    http_response_code(400);
    echo json_encode(['status'=>'error','mensaje'=>'Faltan argumentos.']);
    exit();
}

$titulo = $data->titulo;
$descripcion = empty($data->descripcion) ? null : $data->descripcion;
$fecha_limite = empty($data->fecha_limite) ? null : $data->fecha_limite;

try{

   if($tarea->crear($titulo, $descripcion, $fecha_limite)){
        http_response_code(201);
        echo json_encode(['status'=>'ok','mensaje'=>'Tarea guardada.']);
        exit();
    }

} catch(\PDOException $e){
    http_response_code(500);
    echo json_encode(['status'=>'error','mensaje'=>'Error al crear la Tarea: '. $e->getMessage()]);
    exit();
}