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

                pr($sql);
        
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

    public function atualizarStatus_doAnuncio($id, $novoStatus) {
        $sql = "UPDATE anuncios SET status = :status WHERE id = :id LIMIT 1";
        $params = [
            ':status' => $novoStatus,
            ':id' => $id
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
                    an.id as 'AnuncioID',
                    an.*,
                    aa.*,
                    c.nome as 'nomeCategoria',
                    comerc.nome,
                    comerc.telefone
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

}