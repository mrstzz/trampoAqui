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
use Classes\Conexao;





extract($_POST);
extract($_GET);
extract($_SESSION);
extract($_FILES);


$anuncioArq   = new Anuncio();
$comerciante  = new Comerciante();
$arquivo      = new Arquivo();
$conn         = new Conexao();


$paginaDeRetorno = "./painel_comerciante.php";


    try {
        
        if (@$anuncio) {
            
            // se n achar o $_FILES
            if (!isset($imagem) || $imagem['error'] != UPLOAD_ERR_OK) { throw new Exception("Erro no upload da imagem. O arquivo pode ser muito grande ou corrompido."); }

            $arquivoPasta = new ArquivoUploader(__DIR__ . '/../../uploads');
            $arquivoCriado = $arquivoPasta->upload($imagem); 

            // se o arquivo não for pra pasta /uploads
            if (!$arquivoCriado) { throw new Exception("Falha ao salvar o arquivo físico."); }

            $pdo  = $conn->getPdo();
            $pdo->beginTransaction();

            $idAnuncioCriado = $anuncioArq->insere($titulo, $descricao, $valor, $localidade, $user_id, 'ativo', $categoria_id);

            // se o anuncio não for inserido em anucios
            if (!$idAnuncioCriado) { throw new Exception("Falha ao criar o anúncio."); }


            $insereArquivo = $arquivo->insereArquivo($idAnuncioCriado, '', $arquivoCriado);
            
            //se o nao for inserido em anuncios_arquivos
            if (!$insereArquivo) { throw new Exception("Falha ao registrar o arquivo no banco de dados."); }

            $pdo->commit();

            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Anúncio cadastrado com sucesso!'
            ];
            header("Location: $paginaDeRetorno");
            exit;

        }else if (@$config) {

            $pesquisa = $comerciante->pesquisaComerciante($user_id);

            $semMudancas = ($pesquisa['nome'] == $nome_config) &&
               ($pesquisa['telefone'] == $telefone_config) &&
               ($pesquisa['email'] == $email_config);

            // se os dados forem os mesmos, devolvemos de volta. 
            if ($semMudancas) { throw new Exception("Nenhum dado foi alterado. Forneça novos valores para atualizar."); }

            $novosDados = [
                'nome'     => $nome_config,  
                'email'    => $email_config,  
                'telefone' => $telefone_config  
            ];

            $atualizaDados = $comerciante->atualizaComerciante($user_id, $novosDados);

            if ($atualizaDados) {

                $_SESSION['alert'] = [
                    'type' => 'success',
                    'message' => 'Dados atualizados com sucesso!'
                ];
                header("Location: $paginaDeRetorno");
                exit;

            }else {throw new Exception("Nenhum dado foi alterado. Forneça novos valores para atualizar.");}


        }else if (@$desativar) {

            $desativaAnuncio = $anuncioArq->atualizarStatusAnuncio ($anuncio_id,'desativado');

            if ($desativaAnuncio) {

                $_SESSION['alert'] = [
                        'type' => 'success',
                        'message' => 'Anuncio desativado!'
                    ];
                    header("Location: $paginaDeRetorno");
                    exit;
            }
            else {throw new Exception("Não conseguimos desativar esse anuncio. Gentileza tentar novamente mais tarde!");}

        }
    } catch (Exception $e) {

        // Se a transação foi iniciada, desfaz
        if (isset($pdo) && $pdo->inTransaction()) {
            $pdo->rollBack();
        }

        // Se o arquivo físico foi criado, apagamos ele
        if (!empty($arquivoCriado)) {
            $pasta = __DIR__ .'/../../uploads/';
            $caminhoCompleto = $pasta."$arquivoCriado"; 
            if (file_exists($caminhoCompleto)) {
                unlink($caminhoCompleto);
            }
        }
        $_SESSION['alert'] = [
            'type' => 'error', 
            'message' => $e->getMessage() 
        ];
        header("Location: $paginaDeRetorno");
        exit;
    }



?>









