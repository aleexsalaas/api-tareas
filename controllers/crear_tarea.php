<?php

header("Content-Type: application/json");

require 'config/db.php';
require 'models/Tarea.php';

$db_class = new Database();

$db = $db_class->getConnection();

$tarea = new Tarea($db);

if(!isset($_POST['titulo'])){
    http_response_code(400);
    echo json_encode(['status'=>'error','mensaje'=>'Faltan argumentos.']);
    exit();
}

$titulo = $_POST['titulo'];
$descripcion = empty($_POST['descripcion']) ? null : $_POST['descripcion'];
$fecha_limite = empty($_POST['fecha_limite']) ? null : $_POST['fecha_limite'];

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