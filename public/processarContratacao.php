<?php

require_once __DIR__ . '../../vendor/autoload.php';
require_once  './functions.php';


use Classes\Anuncio;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



extract($_POST);
extract($_SESSION);


$anuncio  = new Anuncio();
$anuncioContrato = $anuncio->pesquisaAnuncioParaContrato($id_anuncio);


if ($anuncioContrato) {
    $insereAnuncioCont = $anuncio->insereAnuncioContratado($anuncioContrato->comerc_id, $user_id,'contratado',$id_anuncio);
}

if ($insereAnuncioCont) {

    $atualizaAnuncio = $anuncio->atualizarStatusAnuncio($id_anuncio,'contratado');

    $_SESSION['flash_message'] = [
        'type' => 'success', 
        'message' => 'Anúncio contratado com sucesso! Você pode verificá-lo em seu perfil.'
    ];
    header("Location: ./index.php");
    
}else{
    $_SESSION['flash_message'] = [
        'type' => 'error', 
        'message' => 'Erro ao inserir o contrato!'
    ];
    header("Location: ./index.php");
}









