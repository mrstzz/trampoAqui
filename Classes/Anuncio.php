<?php
namespace Classes;
use PDO;

class Anuncio extends Conexao {
    public function __construct() {
        parent::__construct();
    }

    public function create($titulo, $descricao, $valor, $localidade, $comerciante_id, $status = 'ativo', $arquivo = null, $categoria = NULL) {
        $sql = "INSERT INTO anuncios (titulo, descricao, valor, localidade, comerciante_id, status, arquivo, categoria,ciado_em) 
                VALUES (:titulo, :descricao, :valor, :localidade, :comerciante_id, :status, :arquivo, :categoria, :criado_em)";
        
        $params = [
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':valor' => $valor,
            ':localidade' => $localidade,
            ':comerciante_id' => $comerciante_id,
            ':status' => $status,
            ':arquivo' => $arquivo,
            ':categoria' => $categoria,
        ];

        return $this->consulta($sql, $params);
        $_SESSION['success'] = "Anúncio criado com sucesso!";
        header("Location: ../public/pages/prestador/painel-comerciante.php");
        exit();
    }

    public function pesquisarPeloId($id) {
        $sql = "SELECT * FROM anuncios WHERE id = :id";
        $params = [':id' => $id];
        return $this->consulta($sql, $params)->fetch();
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
                    an.*,
                    aa.*,
                    comerc.nome,
                    comerc.telefone
                FROM 
                    anuncios an
                INNER JOIN
                    comerciantes comerc ON comerc.id = an.comerc_id
                LEFT JOIN 
                    anuncios_arquivos aa ON aa.anuncio_id = an.id 
                WHERE 
                    an.status LIKE 'ativo'
                $cond";
        // print_r($sql);
        return $this->consulta($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

}