<?php 

class Database {

    private $host = "localhost";
    private $db_name = "api_tareas";
    private $username = "TU_USUARIO_AQUI";
    private $password = "TU_PASSWORD_AQUI";
    private $charset = "utf8mb4";

    public function getConnection(){
        $pdo = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            
            $pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

        } catch (\PDOException $e) {
            http_response_code(500);
            die(json_encode(["status" => "error", "mensaje" => "Error de base de datos: " . $e->getMessage()]));
        }

        return $pdo;
    }
}