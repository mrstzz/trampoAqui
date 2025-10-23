<?php
include_once "../Classes/Conexao.php";


class Cliente extends Conexao{

    var $nome;
    var $email;
    var $senha;
    var $telefone;
    var $cpf;
    var $criado_em;


     function __construct($nome = "", $email = "", $senha = "", $telefone = "", $cpf = "", $criado_em = null) {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->telefone = $telefone;
        $this->cpf = $cpf;
        $this->criado_em = $criado_em;
     }

    function insereCliente(){

        $sql = "INSERT INTO clientes(
                    id,
                    nome,
                    email,
                    senha,
                    telefone,
                    cpf,
                    criado_em
                )
                VALUES('',
                    '$this->nome',
                    '$this->email',
                    '$this->senha',
                    '$this->telefone',
                    '$this->cpf',
                    '$this->criado_em 
                )
                ";
        $result = $this->consulta($sql);

        return (1);
    }


    function removeCliente ($codigo){

    }

    function atualizaCliente($codigo) {

    }

    function pesquisaCliente ($codigo = FALSE, $nome = FALSE){

        $sql = "SELECT * FROM clientes WHERE ";

        $codigo = ($codigo) ? $sql .= "codigo = $codigo" : $sql.="nome LIKE '%$nome%'";
        print_r($sql);


		$res = $this->consulta($sql);
        print_r($res);
		
		if ($res->rowCount() === 0) {
			return []; 
		}

		$dados = $res->fetchAll(PDO::FETCH_OBJ);

        return $dados;

    }

}