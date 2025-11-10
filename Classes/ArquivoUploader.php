<?php
/*
* EM DESENVOLVIMENTO AINDA
* pra salvar o aquivo na pasta vc instancia e passa por parametro, ex:
* $upload = new ImageUploader(__DIR__ . '../uploads');
*
*/

namespace Classes;
use finfo;
use Exception; // Importante

class ArquivoUploader {
    private $upload;
    private $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    private $maxSize = 5 * 1024 * 1024; // 5 MB

    public function __construct(string $diretorio) {
        $this->upload = rtrim($diretorio, '/\\'); 
        
        if (!is_dir($this->upload)) {
           if (!mkdir($this->upload, 0777, true)) {
                throw new Exception("Falha crítica ao criar o diretório de upload em: " . $this->upload);
           }
        }
    }

    /**
     * Processa o upload de um único arquivo.
     * @param array $arquivo O array do arquivo vindo de $_FILES.
     * @return string O novo nome do arquivo em caso de sucesso.
     * @throws Exception Em caso de qualquer falha.
     */
    public function upload(array $arquivo): string {
        
        if ($arquivo['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Erro interno do PHP no upload: Código " . $arquivo['error']);
        }

        if ($arquivo['size'] > $this->maxSize) {
            throw new Exception("Arquivo muito grande (" . round($arquivo['size']/1024/1024, 2) . " MB). Limite de " . ($this->maxSize/1024/1024) . " MB.");
        }

        // Validação de tipo (MIME type)
        $finfo = new finfo(FILEINFO_MIME);
        $rawMimeType = $finfo->file($arquivo['tmp_name']); // Ex: 'image/jpeg; charset=binary'

        if ($rawMimeType === false) {
            throw new Exception("Falha ao ler o tipo MIME do arquivo. O 'finfo' pode não ter permissão.");
        }

        // ======================= AQUI ESTÁ A CORREÇÃO =======================
        // Pega apenas a primeira parte do MIME type, antes do ';'
        $mimeType = explode(';', $rawMimeType)[0]; 
        // $mimeType agora será apenas 'image/jpeg'
        // ====================================================================


        // A validação agora vai comparar 'image/jpeg' com a sua lista
        if (!in_array($mimeType, $this->tiposPermitidos)) {
            // Mantém a mensagem de erro mostrando o tipo original para debug
            throw new Exception(
                "Tipo de arquivo inválido: '$mimeType' (Detectado como: '$rawMimeType'). <br>Permitidos são: " . implode(', ', $this->tiposPermitidos)
            );
        }
        
        // Gerar um nome de arquivo seguro e único
        $extension = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
        $arquivoSeguro = uniqid('', true) . '.' . strtolower($extension);
        
        $destination = $this->upload . DIRECTORY_SEPARATOR . $arquivoSeguro;

        // Mover o arquivo
        if (move_uploaded_file($arquivo['tmp_name'], $destination)) {
            return $arquivoSeguro; // Sucesso!
        } else {
            throw new Exception("Falha ao mover o arquivo. Verifique as permissões de escrita na pasta 'uploads'.");
        }
    }
}