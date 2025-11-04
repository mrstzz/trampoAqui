<?php
namespace Classes;

class Anuncio extends Conexao {
    public function __construct() {
        parent::__construct();
    }

    public function create($titulo, $descricao, $valor, $localidade, $comerciante_id, $status = 'ativo', $arquivo = null) {
        $sql = "INSERT INTO anuncios (titulo, descricao, valor, localidade, comerciante_id, status, arquivo) 
                VALUES (:titulo, :descricao, :valor, :localidade, :comerciante_id, :status, :arquivo)";
        
        $params = [
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':valor' => $valor,
            ':localidade' => $localidade,
            ':comerciante_id' => $comerciante_id,
            ':status' => $status,
            ':arquivo' => $arquivo
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
}