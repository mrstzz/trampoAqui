<?php

namespace Classes;
use PDO;
use Classes\Conexao;
use PDOException;

class Comerciante extends Conexao{

    private Conexao $pdo;

    var $id;
    var $status;
    var $plano;
    var $plano_expira_em;
    var $nome;
    var $email;
    var $senha;
    var $cpf;
    var $telefone;
    var $criado_em;
    var $atualizado_em;

    function __construct() {
		parent::__construct();
	}

    function insereComerciante(){
        if(!empty($nome)){
            $this->nome = $nome;
        }
        if(empty($criado_em)){
            $criado_em = date('Y-m-d H:i:s');
        }

        $sql = "INSERT INTO comerciantes (
            id,
            nome,
            email,
            senha,
            telefone,
            cpf,
            criado_em
        ) VALUES (
            :nome,
            :email,
            :senha,
            :telefone,
            :cpf,
            :criado_em
        )";

        $parametros = [
            ':nome' => $this->nome,
            ':email' => $this->email,
            ':senha' => password_hash($this->senha, PASSWORD_DEFAULT),
            ':telefone' => $this->telefone,
            ':cpf' => $this->cpf,
            ':criado_em' => $this->criado_em
        ];

        try{
            $this->pdo->consulta($sql, $parametros);
            $insertId = $this->pdo->getInsertId();
            return [
                'success' => true,
                'id' => $insertId
            ];
        }catch(PDOException $e){
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }


    function removeComerciante ($id){
        $sql = 'DELETE * FROM comerciantes WHERE id = :id LIMIT 1';
        $arguments = [':id' => $this->id];

        try{
            $stmt = $this->pdo->consulta($sql, $arguments);

            if ($stmt->rowCount() > 0) {
                return [
                    'success' => true,
                    'message' => "Cliente removido com sucesso.",
                    'id' => $id
                ];}else{
                    return [
                        'success' => false,
                        'message' => "Nenhum cliente encontrado com o ID informado.",
                        'id' => $id
                    ];
                }
        }catch(PDOException $e){
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    function atualizaComerciante($id) {
        $sql = "UPDATE comerciantes SET(
            id,
            nome,
            email,
            senha,
            telefone,
            cpf,
            criado_em
        ) VALUES (
            :nome,
            :email,
            :senha,
            :telefone,
            :cpf,
            :criado_em
        ) WHERE id = :id
        ";

        $arguments = ['id' => $this->id];
        
        try{
            $this->pdo->consulta($sql, $arguments);
            $insertId = $this->pdo->getInsertId();
            return [
                'success' => true,
                'id' => $insertId
            ];
        }catch(PDOException $e){
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    function pesquisaComerciante ($id = FALSE, $nome = FALSE){

        $sql = "SELECT * FROM Comerciantes WHERE ";

        $id = ($id) ? $sql .= "id = $id" : $sql.="nome LIKE '$nome'";
		$res = $this->Consulta($sql);
		
		if ($res->rowCount() === 0) {
			return []; 
		}

		$dados = $res->fetchAll(PDO::FETCH_OBJ);

        return $dados;
    }
        function buscaEmailComerciante ($email){
        $sql = "SELECT * FROM comerciantes WHERE email = :email LIMIT 1";
        $arguments = [':email' => $email];

        try{
            $stmt = $this->pdo->consulta($sql, $arguments);
            $response = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $response?:null;
        }catch(PDOException $e){
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    function buscaCpfComerciante ($cpf){
        $sql = "SELECT * FROM comerciantes WHERE cpf = :cpf";
        $parametros = [':cpf' => $cpf];

        try{
            $stmt = $this->pdo->consulta($sql, $parametros);
            $response = $stmt->fetch(PDO::FETCH_ASSOC);

            return $response?:null;

        }catch(PDOException $e){
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

}