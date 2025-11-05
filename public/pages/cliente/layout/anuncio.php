<?php 
session_start();
if($_SESSION['user_type'] != 'cliente') {
    header("Location: ../../login.php");
    exit();
}
include_once '../../../vendor/autoload.php';
use Classes\Anuncio;

$anuncioModel = new Anuncio();

$anuncio = $anuncioModel->pesquisaTodosAnuncios();

?>
<?php foreach ($anuncio as $value) { ?>
    
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="painel-cliente.css">
    <title>Anúncios</title>
    <link rel="stylesheet" href="../../../assets/css/painel-cliente.css">
</head>
<body>
    <div class="post-box">
    <div class="head-bar">
        <div class="img-div">
            <img src="default-user.jpg" alt="">

        </div>

        <div class="user-profile">
            <h1><?php $value['nome']; ?>, <?php $value['idade'] ?></h1>
            <h4><?php $value['localidade'] ?></h4>
        </div>

        <div class="exp">
            <a href="">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="white" viewBox="0 0 256 256"><path d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128Zm56-12a12,12,0,1,0,12,12A12,12,0,0,0,196,116ZM60,116a12,12,0,1,0,12,12A12,12,0,0,0,60,116Z"></path></svg>

            </a>
        </div>
    </div>

    <div class="left-body-box">
            <img src="https://sintricomb.com.br/wp-content/uploads/2018/12/curso.jpg" alt="">
    </div>
    <div class="right-body-box">

        <div class="description">Descrição do Anúncio:</div>
        
        <div class="description-box">
            <?php $value['descricao']; ?>
        </div>
        <div class="container-right-box">

            <div class="value-box">
                <h3>Valor do serviço</h3>
                <h1> <?php $value['valor']  ?></h1>
                <h4 class="diary">diaria</h4>
            </div>

            <form action="#" method="post">
                <div class="hire-box">
                    <a class="favorite-btn" href="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#ffffffff" viewBox="0 0 256 256"><path d="M234.29,114.85l-45,38.83L203,211.75a16.4,16.4,0,0,1-24.5,17.82L128,198.49,77.47,229.57A16.4,16.4,0,0,1,53,211.75l13.76-58.07-45-38.83A16.46,16.46,0,0,1,31.08,86l59-4.76,22.76-55.08a16.36,16.36,0,0,1,30.27,0l22.75,55.08,59,4.76a16.46,16.46,0,0,1,9.37,28.86Z"></path></svg>
                    </a>
                    <button type="submit">Contratar Prestador</button>
                </div>
            </form>

        </div>

        <div class="info-box">
            <div class="left-info">
                <p style="font-weight:bold;">Categorias:</p>
                
                <p> <?php $value['categoria'] ?> </p>

            </div>
            <div class="right-info">
                <p>Emblemas:</p>
                
                <div class="emblemas">
                    <!-- foreach de emblemas -->
                </div>
            </div>
        </div>
    </div>
        <?php }?>

    <div class="interaction-bar">
        <div class="left-hand-inter-bar">

            <a class="interaction-btn" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M176,160a39.89,39.89,0,0,0-28.62,12.09l-46.1-29.63a39.8,39.8,0,0,0,0-28.92l46.1-29.63a40,40,0,1,0-8.66-13.45l-46.1,29.63a40,40,0,1,0,0,55.82l46.1,29.63A40,40,0,1,0,176,160Zm0-128a24,24,0,1,1-24,24A24,24,0,0,1,176,32ZM64,152a24,24,0,1,1,24-24A24,24,0,0,1,64,152Zm112,72a24,24,0,1,1,24-24A24,24,0,0,1,176,224Z"></path></svg>

            </a>
            
            <div class="interaction-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M42.76,50A8,8,0,0,0,40,56V224a8,8,0,0,0,16,0V179.77c26.79-21.16,49.87-9.75,76.45,3.41,16.4,8.11,34.06,16.85,53,16.85,13.93,0,28.54-4.75,43.82-18a8,8,0,0,0,2.76-6V56A8,8,0,0,0,218.76,50c-28,24.23-51.72,12.49-79.21-1.12C111.07,34.76,78.78,18.79,42.76,50ZM216,172.25c-26.79,21.16-49.87,9.74-76.45-3.41-25-12.35-52.81-26.13-83.55-8.4V59.79c26.79-21.16,49.87-9.75,76.45,3.4,25,12.35,52.82,26.13,83.55,8.4Z"></path></svg>
            </div> 

        </div>
        <div class="right-hand-inter-bar">
            

        </div>




    </div>
    </div>
</body>
</html>