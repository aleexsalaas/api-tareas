<?php

header("Content-Type: application/json");

require '../config/db.php';
require '../models/Tarea.php';

$db_class = new Database();
$db = $db_class->getConnection();

$tarea = new Tarea($db);

if(empty($_POST['id']) or empty($_POST['estado'])){
    http_response_code(400);
    echo json_encode(['status'=>'error','mensaje'=>'Faltan argumentos.']);
    exit();
}

$estados_permitidos = ['pendiente', 'en_progreso', 'completada'];

if(!in_array($_POST['estado'], $estados_permitidos)){
    http_response_code(400);
    echo json_encode(['status'=>'error','mensaje'=>'El estado no se corresponde.']);
    exit();
}

$id = $_POST['id'];
$estado = $_POST['estado'];

try{

    if($tarea->actualizarEstado($id, $estado)){
        http_response_code(200);
        echo json_encode(['status'=>'ok','mensaje'=>'Estado actualizado correctamente.']);
        exit();
    }
} catch(\PDOException $e){
    error_log(json_encode('Error critico en Actualizar estado: '. $e->getMessage()));
    http_response_code(500);
    echo json_encode(['status'=>'error','mensaje'=>'Error al actualizar el estado.']);
}
