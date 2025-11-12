<?php
namespace Classes;
use PDO;

class Anuncio extends Conexao {
    public function __construct() {
        parent::__construct();
    }

    public function insere($titulo, $descricao, $valor, $localidade, $comerc_id, $status, $categoria = NULL) {
        $sql = "INSERT INTO anuncios (titulo, descricao, valor, localidade, comerc_id, status, categoria,criado_em) 
                VALUES (:titulo, :descricao, :valor, :localidade, :comerc_id, :status, :categoria, :criado_em)";

        $params = [
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':valor' => $valor,
            ':localidade' => $localidade,
            ':comerc_id' => $comerc_id,
            ':status' => $status,
            ':categoria' => $categoria,
            ':criado_em' => date('Y-m-d H:i:s')
        ];
        
        $result = $this->consulta($sql, $params);
        return $this->getInsertId($result);
    }

    public function pesquisarPeloId($id) {
        $sql = "SELECT 
                    a.id AS 'idAnuncio',
                    a.*,
                    aa.* 
                FROM 
                    anuncios a
                INNER JOIN
                    anuncios_arquivos aa ON aa.anuncio_id = a.id
                WHERE 
                    a.comerc_id = $id";
        $result =  $this->consulta($sql);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }



    public function pesquisaAnuncioAtivo($id) {
        $sql = "SELECT 
                    a.id AS 'idAnuncio',
                    a.*,
                    aa.* 
                FROM 
                    anuncios a
                INNER JOIN
                    anuncios_arquivos aa ON aa.anuncio_id = a.id
                WHERE 
                    a.comerc_id = $id AND
                    a.status = 'ativo'";
        $result =  $this->consulta($sql);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function atualizarStatusAnuncio($id, $novoStatus) {
        $sql = "UPDATE anuncios SET status = :status WHERE id = :id LIMIT 1";
        $params = [
            ':status' => $novoStatus,
            ':id' => $id
        ];
        return $this->consulta($sql, $params);
    }


    public function atualizarStatusContratado($id, $cliente_id, $novoStatus) {
        $sql = "UPDATE anuncios_contratados SET status = :status WHERE id = :id  AND cliente_id = :cliente_id LIMIT 1";
        $params = [
            ':status' => $novoStatus,
            ':id' => $id,
            ':cliente_id' => $cliente_id
        ];
        return $this->consulta($sql, $params);
    }

    public function deletar($id) {
        $sql = "DELETE FROM anuncios WHERE id = :id LIMIT 1";
        $params = [':id' => $id];
        return $this->consulta($sql, $params);
    }

    public function pesquisaTodosAnuncios($carrossel = NULL) {
        $cond = ($carrossel) ? 'ORDER BY an.criado_em LIMIT 10': '';
        $sql = "SELECT 
                    an.id as 'anuncioID',
                    an.*,
                    aa.*,
                    c.nome as 'nomeCategoria',
                    comerc.nome,
                    comerc.telefone,
                    comerc.data_nascimento
                FROM 
                    anuncios an
                INNER JOIN
                    comerciantes comerc ON comerc.id = an.comerc_id
                INNER JOIN
                    categorias c ON c.id = an.categoria
                LEFT JOIN 
                    anuncios_arquivos aa ON aa.anuncio_id = an.id 
                WHERE 
                    an.status LIKE 'ativo'
                $cond";
            $result = $this->consulta($sql);
            return $result->fetchAll(PDO::FETCH_OBJ);
    }



    public function pesquisaAnuncioParaContrato($id) {
        $sql = "SELECT 
                    a.id AS 'idAnuncio',
                    a.*,
                    aa.*,
                    c.nome
                FROM 
                    anuncios a
                INNER JOIN
                    anuncios_arquivos aa ON aa.anuncio_id = a.id
                INNER JOIN
                    comerciantes c ON c.id = a.comerc_id 
                WHERE 
                    a.id = $id";
        $result =  $this->consulta($sql);
        return $result->fetch(PDO::FETCH_OBJ);
    }


    public function pesquisaAnunciosContratados($id) {
        $sql = "SELECT 
                    a.id AS 'idAnuncio',
                    a.*,
                    aa.*,
                    ac.id AS 'idContrato', 
                    ac.*,
                    c.nome AS 'comercNome' 
                FROM 
                    anuncios_contratados ac
                INNER JOIN
                    anuncios a ON a.id =  ac.anuncio_id
                INNER JOIN
                    anuncios_arquivos aa ON aa.anuncio_id = a.id
                INNER JOIN
                    comerciantes c ON c.id = ac.comerc_id 
                WHERE 
                    ac.cliente_id = $id";
        $result =  $this->consulta($sql);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function insereAnuncioContratado($comerc_id, $cliente_id, $status, $anuncio_id) {
        $sql = "INSERT INTO anuncios_contratados (comerc_id, cliente_id, status, data_de_contrato, anuncio_id) 
                VALUES (:comerc_id, :cliente_id, :status, :data_de_contrato, :anuncio_id)";

        $params = [
            ':comerc_id' => $comerc_id,
            ':cliente_id' => $cliente_id,
            ':status' => $status,
            ':data_de_contrato' => date('Y-m-d H:i:s'),
            ':anuncio_id' => $anuncio_id
        ];
        $result = $this->consulta($sql, $params);
        return $this->getInsertId($result);
    }

    public function pesquisaTodasCategorias(){
        $sql = "SELECT * FROM categorias"; 

        $result = $this->consulta($sql);
        return $result->fetchAll(PDO::FETCH_OBJ);

    }

    public function buscaNomeCatRetornaID($nome){

        $sql = "SELECT id FROM categorias WHERE nome LIKE '$nome'"; 
        $result = $this->consulta($sql);
        return $result->fetch(PDO::FETCH_OBJ);

    
    }

}