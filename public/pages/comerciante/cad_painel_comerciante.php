<?php

/** 
* Arquivo responsável por executar todas as opc do painel
*
*
*/


require_once __DIR__ . '../../../../vendor/autoload.php';
require_once '../../functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



use Classes\Anuncio;
use Classes\Cliente;
use Classes\Comerciante;
use Classes\Arquivo;
use Classes\ArquivoUploader;

extract($_POST);
extract($_SESSION);
extract($_FILES);


$anuncioArq      = new Anuncio();
$comerciante  = new Comerciante();
$arquivo      = new Arquivo();




$paginaDeRetorno = "./painel_comerciante.php";

try {
    if (!isset($imagem) || $imagem['error'] != UPLOAD_ERR_OK) {
        throw new Exception("Erro no upload da imagem. O arquivo pode ser muito grande ou corrompido.");
    }

    $arquivoPasta = new ArquivoUploader(__DIR__ . '/../../uploads');
    $arquivoCriado = $arquivoPasta->upload($imagem); 

    if (!$arquivoCriado) {
        throw new Exception("Falha ao salvar o arquivo no servidor.");
    }

    $insereAnuncio = $anuncioArq->insere($titulo, $descricao,$valor,$localidade,$user_id,'ativo');
    if (!$insereAnuncio) {
        throw new Exception("Falha ao criar o anúncio no banco de dados.");
    }

    $insereArquivo = $arquivo->insereArquivo($insereAnuncio, '',$arquivoCriado);

    if (!$insereArquivo) {
        throw new Exception("Falha ao registrar o arquivo no banco de dados.");
    }


   

    $_SESSION['flash_message'] = [
        'type' => 'success', 
        'message' => 'Anúncio cadastrado com sucesso!'
    ];
    header("Location: $paginaDeRetorno");
    exit;

} catch (Exception $e) {
    $_SESSION['flash_message'] = [
        'type' => 'error', 
        'message' => $e->getMessage() 
    ];
    header("Location: $paginaDeRetorno");
    exit;
}
?>









