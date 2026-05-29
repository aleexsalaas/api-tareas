<?php

class Usuario{

    private $conn;
    private $table_name = 'usuarios';

    public function __construct($db){
        $this->conn = $db;
    }

    public function getUserByEmail($email){
        $query = 'SELECT * FROM '.$this->table_name.' WHERE email = :email';

        $stmt = $this->conn->prepare($query);

        $stmt->execute([':email'=> $email]);

        return $stmt;
    }

    public function register($email, $password){
        $query = 'INSERT INTO '.$this->table_name.'(email,password) VALUES(:email,:password)';
        
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([':email'=>$email,':password'=>$password]);
    }
}