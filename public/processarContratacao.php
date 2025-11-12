<?php

require_once __DIR__ . '../../vendor/autoload.php';
require_once  './functions.php';


use Classes\Anuncio;
use Classes\Conexao;
use Classes\Chat;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



extract($_POST);
extract($_SESSION);

if (!$user_id) {
    $_SESSION['alert'] = [
        'type' => 'error', 
        'message' => 'Você precisa estar logado para contratar algum serviço!'
    ];
    header("Location: ./pages/auth/login.php");
    exit();

}

if ($user_type == 'comerciante') {
    $_SESSION['alert'] = [
        'type' => 'error', 
        'message' => 'Funcionalidade exclusiva para clientes!'
    ];

    header("Location: ./index.php");
    exit();

}


$anuncio  = new Anuncio();
$anuncioContrato = $anuncio->pesquisaAnuncioParaContrato($id_anuncio);


if ($anuncioContrato) {
    $insereAnuncioCont = $anuncio->insereAnuncioContratado($anuncioContrato->comerc_id, $user_id,'contratado',$id_anuncio);

    $db = new Conexao();
    $pdo = $db->getPdo(); // Pega a conexão PDO da sua classe Conexao
    $chat = new Chat();

    try {
        $pdo->beginTransaction();


        $insereChat = $chat->insereChat($user_id,$anuncioContrato->comerc_id);

        $stmtAnuncio = $db->consulta("SELECT titulo, valor FROM anuncios WHERE id = ?", [$id_anuncio]);
        $anuncioInfo = $stmtAnuncio->fetch(PDO::FETCH_ASSOC);
        
        $tituloAnuncio = $anuncioInfo['titulo'] ?? 'Anúncio não encontrado';
        $valorAnuncio  = $anuncioInfo['valor'] ?? 'N/A';

        $message_text = "✨ **Chat iniciado** ✨\n" .
                        "Serviço contratado: **{$tituloAnuncio}**\n" .
                        "Valor: R$ {$valorAnuncio}";
                        
        $encrypted_message = Classes\EncryptionHelper::encrypt($message_text);

        $insereMsgCliente     = $chat->insereConversa($insereChat,0,$user_id,$encrypted_message);
        $insereMsgComerciante = $chat->insereConversa($insereChat,0,$anuncioContrato->comerc_id,$encrypted_message);

        $pdo->commit();
        
    } catch (Exception $e) {
        $pdo->rollBack();

        $_SESSION['alert'] = [
        'type' => 'error', 
        'message' => 'Erro ao inserir o contrato!'
        ];
        header("Location: ./index.php");
        exit();

    }
}

if ($insereAnuncioCont) {

    $atualizaAnuncio = $anuncio->atualizarStatusAnuncio($id_anuncio,'contratado');

    $_SESSION['alert'] = [
        'type' => 'success', 
        'message' => 'Anúncio contratado com sucesso! Você pode verificá-lo em seu perfil.'
    ];
    header("Location: ./index.php");
    
}else{
    $_SESSION['alert'] = [
        'type' => 'error', 
        'message' => 'Erro ao inserir o contrato!'
    ];
    header("Location: ./index.php");
    exit();
}









