<?php
// api/avaliar.php

require_once __DIR__ . '/../../vendor/autoload.php';
use Classes\Conexao;
use Classes\Reputacao;
use Classes\Anuncio;

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/cliente/painel_cliente.php');
    exit;
}

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'cliente') {
    $_SESSION['alert'] = [
        'type' => 'error', 
        'message' => 'Cliente nao encontrado!'
        ];
        header("Location: ../index.php");
    exit;
}

$cliente_id = $_SESSION['user_id'];

// --- Coleta de Dados do Formulário ---
$contrato_id = (int)$_POST['contrato_id'];
$comerc_id = (int)$_POST['comerc_id'];
$anuncio_id = (int)$_POST['anuncio_id'];
$nota = (float)$_POST['nota'];
$comentario = trim($_POST['comentario']);
$paginaDeRetorno = '../pages/cliente/painel_cliente.php#anuncio'; // Volta para a aba certa

// Validação simples
if (empty($contrato_id) || empty($comerc_id) || empty($anuncio_id) || $nota < 1 || $nota > 5) {
    $_SESSION['alert'] = ['type' => 'error', 'message' => 'Dados de avaliação inválidos.'];
    header("Location: $paginaDeRetorno");
    exit;
}


try {
    $db = new Conexao();
    $pdo = $db->getPdo();

    // 1. Inicia a Transação
    $pdo->beginTransaction();


    // insere reputacao
    $reputacao = new Reputacao();
    $insereAvaliacao = $reputacao->insereAvaliacao($contrato_id,$cliente_id,$comerc_id,$nota,$comentario);

    // atualiza status contratado
    $anuncio = new Anuncio();
    $atualizaStatusContrato = $anuncio->atualizarStatusContratado($contrato_id,$cliente_id,'concluido');


    // atualiza status anuncio para concluido tbm
    $atualizaStatusAnuncio = $anuncio->atualizarStatusAnuncio($anuncio_id,'concluido');

    $reputacao = new Reputacao();
    $reputacao->atualizarReputacao($comerc_id);

    // Se tudo deu certo, vambora!
    $pdo->commit();

    $_SESSION['alert'] = [
        'type' => 'success', 
        'message' => 'Avaliação enviada com sucesso! Obrigado!'
    ];

} catch (Exception $e) {
    if ($pdo && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    $_SESSION['alert'] = [
        'type' => 'error', 
        'message' => 'Erro ao enviar avaliação. (Talvez você já tenha avaliado?)'
    ];

}

header("Location: $paginaDeRetorno");
exit;