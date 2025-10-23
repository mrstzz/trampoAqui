<?php

include_once "../Classes/Conexao.php";
include_once "../Classes/Cliente.php";


extract($_POST);


if (empty($pesquisa)) {
    header("Location: ../index.php?msg=slslaask");
    exit;
}

$objCliente = new Cliente();


if ($tipo == 'cliente') {
    $objCliente->pesquisaCliente(false, $pesquisa);
    print_r($objCliente);die;
    
}else if ($tipo == 'prestador') {
    
} else if ($tipo == 'anuncio') {
    # code...
}else{

}
