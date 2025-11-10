<?php

namespace Classes;
use Classes\Conexao;

class Arquivo extends Conexao {

    public $id;
    public $nome;
    public $anuncioId;
    public $tipo;
    public $caminhoArquivo;
    public $fotoPerfil;
    public $criado_em;


    function __construct() {
		parent::__construct();
	}

    function insereArquivo($anuncioId, $tipo = NULL, $filename) {

        $tipo = ($tipo) ? "$tipo" : "mostruario";
        $sql = "INSERT INTO anuncios_arquivos (anuncio_id, tipo, caminho_arquivo) VALUES ($anuncioId, '$tipo', '$filename')";
        $result = $this->consulta($sql);
        return $result;
    }



    public function excluiArquivo($anuncioId, $comercId) {

        // Primeiro, pega o nome do arquivo para deletar do disco
        $sql = "SELECT caminho_arquivo FROM anuncios_arquivos WHERE anuncio_id = $anuncioId";
        $result = $this->consulta($sql);
        $file = $result->fetchColumn();

        if ($file) {
            // Deleta o registro do banco
            $deleteSql = "DELETE FROM anuncios_arquivos WHERE anuncio_id = $anuncioId";
            $resultDelete = $this->consulta($deleteSql);
            
            if ($resultDelete) {
                // Se deletou do banco, deleta o arquivo físico
                $filePath = __DIR__ . '../uploads/' . $file;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                return true;
            }
        }
        return false;
    }
   


}