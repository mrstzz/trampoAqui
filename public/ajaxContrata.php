<?php

header('Content-Type: application/json');

include_once '../vendor/autoload.php';
include_once './functions.php'; 
use Classes\Anuncio;

// Pega o ID da URL e sanitiza
$anuncio_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$anuncio_id) {
    // Se o ID for inválido ou não existir
    echo json_encode(['error' => 'ID do anúncio inválido.']);
    exit;
}

try {
    $anuncioModel = new Anuncio();
    
    $anuncio = $anuncioModel->pesquisaAnuncioParaContrato($anuncio_id);

    if ($anuncio) {
        echo json_encode($anuncio);
    } else {
        echo json_encode(['error' => 'Anúncio não encontrado.']);
    }

} catch (Exception $e) {
    echo json_encode(['error' => 'Erro ao conectar com o banco de dados: ' . $e->getMessage()]);
}

?>