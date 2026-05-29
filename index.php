<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");

$method = $_SERVER['REQUEST_METHOD'];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$recurso = $uri[3] ?? '';

switch($recurso){
    case 'tarea':
        if($method === 'GET'){
            require 'controllers/listar_tareas.php';
        } elseif( $method === 'POST'){
            require 'controllers/crear_tarea.php';
        } elseif( $method === 'PUT'){
            require 'controllers/actualizar_estado.php';
        } elseif($method === 'DELETE'){
            require 'controllers/borrar_tarea.php';
        } else {
            http_response_code(405);
            echo json_encode([
                'Error'=>'Metodo no permitido'
            ]);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode([
            'Error'=>'Ruta no encontrada'
        ]);
        break;
}