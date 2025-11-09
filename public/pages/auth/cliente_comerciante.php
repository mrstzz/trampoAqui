<?php
//aqui é o arquivo onde o usuario escolhe ser comerciante ou cliente
session_start(); 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecione Seu Perfil</title>
    <link rel="stylesheet" href="../../assets/css/cliente_comerciante.css">
    </head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../assets/images/logo-trampo-aqui-white-new50.png" type="image/x-icon">
<body>

    <div class="selection-container">
        <h1>Como você irá utilizar nossa plataforma?</h1>
        <p>Selecione o perfil para prosseguirmos com seu cadastro!</p>

        <div class="card-wrapper">
            <form action="../../auth/setPerfil.php" method="post">
                <!-- passo um hidden com value comerciante -->
                <input type="hidden" name="perfil" value="Comerciante">
                <div class="card role-card" id="card-comerciante" style = "width: 18rem;">
                    <div class="icon-placeholder"><img src="../../assets/images/icone-comercio-200.png" alt=""></div>
                    <h2>Comerciante</h2>
                    <p>Quero vender, gerenciar produtos e serviços e encontrar clientes.</p>
                    <button class="btn" style="background-color: orange; border-color: orange; color: white;"><strong>Sou Comerciante</strong></button>
                </div>
            </form>
            
            <form action="../../auth/setPerfil.php" method="post">
                <!-- passo um hidden com value cliente -->
                 <input type="hidden" name="perfil" value="Cliente">
            <div class="card role-card" id="card-cliente" style = "width: 18rem;">
                    <div class="icon-placeholder"><img src="../../assets/images/icone-cliente-200.png" alt="cliente-feliz"></div>
                    <h2>Cliente</h2>
                    <p>Quero navegar, e encontrar bons profissionais para minhas necessidades.</p>
                    <button class="btn" style="background-color: orange; border-color: orange; color: white;"><strong>Sou Cliente</strong></button>
                </div>
            </form>

            
        </div>
            <button class="btn bg-dark py-2 mt-5 d-block mx-auto px-5"><a href="../../pages/auth/login.php" class="text-decoration-none text-light">Cancelar Cadastro</a></button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>