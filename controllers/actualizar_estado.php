<?php

header("Content-Type: application/json");

require 'config/db.php';
require 'models/Tarea.php';

$db_class = new Database();
$db = $db_class->getConnection();

$tarea = new Tarea($db);

$data = json_decode(file_get_contents("php://input"));

if(empty($data->id) or empty($data->estado)){
    http_response_code(400);
    echo json_encode(['status'=>'error','mensaje'=>'Faltan argumentos.']);
    exit();
}

$estados_permitidos = ['pendiente', 'en_progreso', 'completada'];

if(!in_array($data->estado, $estados_permitidos)){
    http_response_code(400);
    echo json_encode(['status'=>'error','mensaje'=>'El estado no se corresponde.']);
    exit();
}

$id = $data->id;
$estado = $data->estado;

try{

    if($tarea->actualizarEstado($id, $estado)){
        http_response_code(200);
        echo json_encode(['status'=>'ok','mensaje'=>'Estado actualizado correctamente.']);
        exit();
    } else {
        http_response_code(404);
        echo json_encode(['status'=>'error','mensaje'=>'La tarea no existe.']);
    }
} catch(\PDOException $e){
    error_log('Error critico en Actualizar estado: '. $e->getMessage());
    http_response_code(500);
    echo json_encode(['status'=>'error','mensaje'=>'Error al actualizar el estado.']);
}
