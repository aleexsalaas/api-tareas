<?php

header("Content-Type: application/json");

require 'config/db.php';
require 'models/Tarea.php';

$db_class = new Database();
$db = $db_class->getConnection();

$tarea = new Tarea($db);

$data = json_decode(file_get_contents("php://input"));

if(empty($data->id)){
    http_response_code(400);
    echo json_encode(['status'=>'error','mensaje'=>'Faltan argumentos.']);
    exit();
}

$id = $data->id;

try{

    if($tarea->borrar($id)){
        http_response_code(200);
        echo json_encode(['status'=>'ok','mensaje'=>'Tarea eliminada.']);
        exit();
    } else{
        http_response_code(404);
        echo json_encode(['status'=>'error','mensaje'=>'La tarea no existe.']);
    }

} catch(\PDOException $e){
    error_log("Error crítico en borrar_tarea.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status'=>'error','mensaje'=>'Error al eliminar la tarea.']);
}