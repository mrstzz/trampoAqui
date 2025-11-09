<?php

namespace Classes;
use PDO;
use Classes\Conexao;
use APP\Models\funcoesGlobais;
use PDOException;

class Cliente extends Conexao{

    public $id;
    public $nome;
    public $email;
    public $data_nascimento;
    public $senha;
    public $telefone;
    public $cpf;
    public $criado_em;


    function __construct() {
		parent::__construct();
	}

    function hashSenha($senha){
        return password_hash($senha, PASSWORD_DEFAULT);
    }

    function insereCliente($nome, $email, $data_nascimento, $senha, $telefone, $cpf, $criado_em = null){
        if(!empty($nome)){
            $this->nome = $nome;
        }
        if(empty($criado_em)){
            $criado_em = date('Y-m-d H:i:s');
        }
        if(!empty($email)){
            $this->email = $email;
        }
        $this->hashSenha($senha);

        $sql = "INSERT INTO clientes (
            nome,
            email,
            data_nascimento,
            senha,
            telefone,
            cpf,
            criado_em
        ) VALUES (
            :nome,
            :email,
            :data_nascimento,
            :senha,
            :telefone,
            :cpf,
            :criado_em
        )";

        $parametros = [
            ':nome' => $nome,
            ':email' => $email,
            ':data_nascimento' => $data_nascimento,
            ':senha' => $senha,
            ':telefone' => $telefone,
            ':cpf' => $cpf,
            ':criado_em' => $criado_em
        ];

        try{
            $this->consulta($sql, $parametros);
            $insertId = $this->getInsertId();
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
            $stmt = $this->consulta($sql, $arguments);

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
            $this->consulta($sql, $arguments);
            $insertId = $this->getInsertId();
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
            $stmt = $this->consulta($sql, $arguments);
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
            $stmt = $this->consulta($sql, $parametros);
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