<?php

header('Content-Type: application/json');

require '../config/db.php';
require '../models/Tarea.php';

$dbclass = new Database();

$db = $dbclass->getConnection();

$tarea = new Tarea($db);

try{
  $stmt = $tarea->getTodas();

  $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  http_response_code(200);
  echo json_encode($datos);

} catch(\PDOException $e){
    http_response_code(500);
    echo json_encode(['status'=>'error','mensaje'=>'Error: '. $e->getMessage()]);
}