<?php

namespace Classes;
use PDO;
use Classes\Conexao;
use PDOException;

class Comerciante extends Conexao{

    public $id;
    public $status;
    public $plano;
    public $plano_expira_em;
    public $nome;
    public $email;
    public $senha;
    public $cpf;
    public $telefone;
    public $criado_em;
    public $atualizado_em;

    function __construct() {
		parent::__construct();
	}

public function insereComerciante($nome, $status, $email, $data_nascimento, $senha, $telefone, $cpf, $criado_em = null)
{
    if (empty($criado_em)) {
        $criado_em = date('Y-m-d H:i:s');
    }
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO comerciantes (
                nome,
                status,
                email,
                data_nascimento,
                senha,
                telefone,
                cpf,
                criado_em
            ) VALUES (
                :nome,
                :status,
                :email,
                :data_nascimento,
                :senha,
                :telefone,
                :cpf,
                :criado_em
            )";

    $parametros = [
        ':nome' => $nome,
        ':status' => $status,
        ':email' => $email,
        ':data_nascimento' => $data_nascimento,
        ':senha' => $senhaHash,
        ':telefone' => $telefone,
        ':cpf' => $cpf,
        ':criado_em' => $criado_em
    ];
    

    try {
        $this->consulta($sql, $parametros);
        $insertId = $this->getInsertId();
        return [
            'success' => true,
            'id' => $insertId
        ];
    } catch (PDOException $e) {
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

    function pesquisaComerciante ($id = NULL, $nome = NULL){

        $sql = "SELECT 
                    id,
                    status,
                    nome,
                    criado_em,
                    telefone 
                FROM Comerciantes 
                WHERE ";

        $id = ($id) ? $sql .= "id = $id" : $sql.="nome LIKE '%$nome%'";
		$res = $this->Consulta($sql);

		if ($res->rowCount() === 0) {
			return []; 
		}
		$dados = $res->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
    }
        function buscaEmailComerciante ($email){
        $sql = "SELECT * FROM comerciantes WHERE email = :email LIMIT 1";
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

    function buscaCpfComerciante ($cpf){
        $sql = "SELECT * FROM comerciantes WHERE cpf = :cpf";
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


    public function atualizaFotoPerfiç($comercId) {
        // Remove o status 'perfil' da foto antiga, se houver
        $sql = "UPDATE comerciante_fotos SET tipo = 'galeria' WHERE comerc_id = $comercId AND tipo = 'perfil'";
        $result = $this->consulta($sql);
        
    }
    

}