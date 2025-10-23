<?php


class Comerciante extends Conexao{

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

    function __construct($nome,$senha,$telefone,$cpf,$criado_em) {
        
        $this->status = $status;
        $this->plano = $plano;
        $this->plano_expira_em = $plano_expira_em;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->cpf = $cpf;
        $this->telefone = $telefone;
        $this->$criado_em = $criado_em;
        $this->$atualizado_em = $atualizado_em;
    }


    function insereComerciante(){

        $sql = "INSERT INTO Comerciantes(
                    id,
                    status,
                    plano_expira_em,
                    nome,
                    email,
                    senha,
                    telefone,
                    cpf,
                    criado_em,
                    atualizado_em
                )
                VALUES('',
                    '$this->status',
                    '$this->plano',
                    '$this->plano_expira_em',
                    '$this->nome',
                    '$this->email',
                    '$this->senha',
                    '$this->telefone',
                    '$this->cpf',
                    '$this->criado_em',
                    '$this->atualizado_em'

        return (1);
    }


    function removeComerciante ($id){

    }

    function atualizaComerciante($id) {

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

}