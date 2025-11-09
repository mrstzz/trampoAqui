<?php
/*
* EM DESENVOLVIMENTO AINDA
* pra salvar o aquivo na pasta vc instancia e passa por parametro, ex:
* $upload = new ImageUploader(__DIR__ . '../uploads');
*
*/


class ImageUploader {
    private $upload;
    private $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    private $maxSize = 5 * 1024 * 1024; // 5 MB

    public function __construct(string $diretorio) {
        $this->upload = $diretorio;
    }

    /**
     * Processa o upload de um único arquivo.
     * @param array $arquivo O array do arquivo vindo de $_FILES.
     * @return string|false O novo nome do arquivo em caso de sucesso, ou false em caso de falha.
     */
    public function upload(array $arquivo) {
        if ($arquivo['error'] !== UPLOAD_ERR_OK) {
            error_log("Upload error: " . $arquivo['error']);
            return false;
        }

        // Validação de tamanho
        if ($arquivo['size'] > $this->maxSize) {
            error_log("arquivo too large " . $arquivo['name']);
            return false;
        }

        // Validação de tipo (MIME type)
        $finfo = new finfo(FILEINFO_MIME);
        $mimeType = $finfo->file($arquivo['tmp_name']);
        if (!in_array($mimeType, $this->tiposPermitidos)) {
            error_log("Invalid arquivo type: " . $mimeType);
            return false;
        }

        // Gerar um nome de arquivo seguro e único
        $extension = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
        $arquivoSeguro = uniqid('', true) . '.' . strtolower($extension);
        
        $destination = $this->upload . '/' . $arquivoSeguro;

        // Mover o arquivo do diretório temporário para o destino final
        if (move_uploaded_file($arquivo['tmp_name'], $destination)) {
            return $arquivoSeguro;
        }

        error_log("Failed to move uploaded arquivo: " . $arquivo['name']);
        return false;
    }
}
