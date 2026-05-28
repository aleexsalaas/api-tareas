<?php

header("Content-Type: application/json");

require '../config/db.php';
require '../models/Tarea.php';

$db_class = new Database();
$db = $db_class->getConnection();

$tarea = new Tarea($db);

if(empty($_POST['id'])){
    http_response_code(400);
    echo json_encode(['status'=>'error','mensaje'=>'Faltan argumentos.']);
    exit();
}

$id = $_POST['id'];

try{

    if($tarea->borrar($id)){
        http_response_code(200);
        echo json_encode(['status'=>'ok','mensaje'=>'Tarea eliminada.']);
        exit();
    }

} catch(\PDOException $e){
    error_log("Error crítico en borrar_tarea.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status'=>'error','mensaje'=>'Error al eliminar la tarea.']);
}