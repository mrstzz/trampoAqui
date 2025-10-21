<?php

namespace Classes;

use Database;
use PDO;
use Core\Router;


class Usuario{
    private $connection;

    public function __construct($pdo){
        $this->connection = $pdo;
    }

    public function loginSubmit(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            die();
        }
         
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $buscaCliente = $this->connection->prepare('SELECT * FROM clientes WHERE email= :email');
        $buscaCliente->execute([
            'email' => $email
        ]);
        $cliente = $buscaCliente->fetch(PDO::FETCH_ASSOC);

        if($cliente){
            if(password_verify($senha, $cliente['senha'])){
                // login como cliente
            }
        }else{
            $buscaComerciante = $this->connection->prepare('SELECT * from comerciantes WHERE email= :email');
            $buscaComerciante->execute([
                'email' => $email
            ]);
            $comerciante = $buscaComerciante->fetch(PDO::FETCH_ASSOC);

            if($comerciante){
                if(password_verify($senha, $comerciante['senha'] )){
                    //login como comerciante
                }
            }
        }
    }

    public function create(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            die();
        }

        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        $cpf = $_POST['cpf'] ?? '';
        $uf = $_POST['uf'] ?? '';
        $cidade = $_POST['cidade'] ?? '';

        $novo = $this->connection->prepare(
            'INSERT INTO clientes (nome, email, senha, telefone, cpf, uf, cidade) 
            VALUES (:nome, :email, :senha, :telefone, :cpf, :uf, :cidade)'
        );
        return $novo->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':senha' => $senha,
            ':telefone' => $telefone,
            ':cpf' => $cpf,
            ':uf' => $uf,
            ':cidade' => $cidade
        ]);
    }

}