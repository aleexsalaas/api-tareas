<?php

header("Content-Type: application/json");

require 'config/db.php';
require 'models/Usuario.php';

$db_class = new Database;

$db = $db_class->getConnection();

$user = new Usuario($db);

$data = json_decode(file_get_contents("php://input"));

if(empty($data->email) or empty($data->password)){
    http_response_code(400);
    echo json_encode(['status'=>'error','mensaje'=>'Faltan argumentos.']);
    exit();
}

if(!filter_var($data->email, FILTER_VALIDATE_EMAIL)){
    http_response_code(400);
    echo json_encode(['status'=>'error','mensaje'=>'Formato del email no valido.']);
    exit();
}

if(strlen($data->password) < 6){
    http_response_code(400);
    echo json_encode(['status'=>'error','mensaje'=>'La contraseña debe tener mas de 6 caracteres']);
    exit();
}

$email = $data->email;
$password_hash = password_hash($data->password, PASSWORD_BCRYPT);

try{

    if($user->register($email, $password_hash)){
        http_response_code(200);
        echo json_encode(['status'=>'ok','mensaje'=>'Usuario registrado exitosamente.']);
        exit();
    }
} catch(\PDOException $e){
    error_log(json_encode('Error critico en Registro: '. $e->getMessage()));
    http_response_code(500);
    echo json_encode(['status'=>'error','mensaje'=>'Error al registrar al usuario.']);
}