<?php

header("Content-Type: application/json");

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if(empty($_SERVER['HTTP_AUTHORIZATION'])){
    http_response_code(401);
    echo json_encode(['status'=>'error','mensaje'=>'Token no proporcionado']);
    exit();
}

$cabecera = $_SERVER['HTTP_AUTHORIZATION'];

$key = "clave_secreta_para_que_el_token_funcione"; //debe tener minima una longitud de 32 caracteres...

$token_limpio = str_replace("Bearer ", "", $cabecera);

try{

JWT::decode($token_limpio, new Key($key, 'HS256'));

} catch(\Exception $e){
    http_response_code(401);
    echo json_encode(['status'=>'error','mensaje'=>'Token invalido o caducado']);
    exit();
}