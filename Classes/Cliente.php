<?php

namespace Classes;
use PDO;
use Classes\Conexao;
use APP\Models\funcoesGlobais;
use PDOException;

class Cliente extends Conexao{

    var $id;
    var $nome;
    var $email;
    var $senha;
    var $telefone;
    var $cpf;
    var $criado_em;

    private Conexao $pdo;


     function __construct() {
		parent::__construct();
	}

    function insereCliente($nome){
        if(!empty($nome)){
            $this->nome = $nome;
        }
        if(empty($criado_em)){
            $criado_em = date('Y-m-d H:i:s');
        }

        $sql = "INSERT INTO clientes (
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


    function removeCliente ($id){
        $sql = 'DELETE * FROM clientes WHERE id = :id LIMIT 1';
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

    function atualizaCliente($id) {
        $sql = "UPDATE clientes SET(
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

    function pesquisaCliente ($codigo = FALSE, $nome = FALSE){

        $sql = "SELECT * FROM clientes WHERE ";

        $codigo = ($codigo) ? $sql .= "codigo = $codigo" : $sql.="nome LIKE '%$nome%'";


		$res = Conexao::consulta($sql);
		
		if ($res->rowCount() === 0) {
			return []; 
		}
    
		$dados = $res->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
    }

    function buscaEmailCliente ($email){
        $sql = "SELECT * FROM clientes WHERE email = :email LIMIT 1";
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

    function buscaCpfCliente ($cpf){
        $sql = "SELECT * FROM clientes WHERE cpf = :cpf";
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