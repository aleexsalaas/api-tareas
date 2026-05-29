<?php



header("Content-Type: application/json");

require 'config/db.php';
require 'models/Usuario.php';

use Firebase\JWT\JWT;

$db_class = new Database();
$db = $db_class->getConnection();

$user = new Usuario($db);

$data = json_decode(file_get_contents("php://input"));

if(empty($data->email) or empty($data->password)){
    http_response_code(400);
    echo json_encode(['status'=>'error','mensaje'=>'Faltan argumentos']);
    exit();
}
$key = "clave_secreta_para_que_el_token_funcione"; //debe tener minima una longitud de 32 caracteres...
$email = $data->email;
$password = $data->password;

try{
    $stmt = $user->getUserByEmail($email);

    $usuario_encontrado = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$usuario_encontrado or !password_verify($password, $usuario_encontrado['password'])){
        http_response_code(401);
        echo json_encode(['status'=>'error','mensaje'=>'La contraseña o el correo no coinciden']);
        exit();
    }

    $payload = [
        'iat'=> time(),
        'exp'=> time()+3600,
        'data'=> [
            'id'=> $usuario_encontrado['id'],
            'email'=> $usuario_encontrado['email']
        ]
    ];

    $jwt = JWT::encode($payload, $key, 'HS256');

    http_response_code(200);
    echo json_encode([
        'status'=>'ok',
        'mensaje'=>'Sesion iniciada correctamente',
        'token'=> $jwt
    ]);
    exit();

} catch(\PDOException $e){
    error_log(json_encode("Error critico en Login: ". $e->getMessage()));
    http_response_code(500);
    echo json_encode(['status'=>'error','mensaje'=>'No se ha podido iniciar sesion']);
    exit();
}