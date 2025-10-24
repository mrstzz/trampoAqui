<?php

include_once "../Classes/Conexao.php";
include_once "../Classes/Cliente.php";
include_once "../Classes/Comerciante.php";


extract($_POST);


if (empty($pesquisa)) {
    header("Location: ../index.php?msg=Campo de pesquisa vazio!");
    exit;
}

$objCliente         = new Cliente();
$objComerciante     = new Comerciante();


if ($tipo == 'cliente') {
    $busca= $objCliente->pesquisaCliente(false, $pesquisa);
}else if ($tipo == 'prestador') {
    $busca= $objComerciante->pesquisaComerciante(false, $pesquisa);
} else if ($tipo == 'anuncio') {
    // $busca = 
}else{
    // tags =
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>

    <div class="container mt-4">
        <h1 class="mb-3">Pesquisa</h1>

        <form action="" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" 
                       name="busca" 
                       class="form-control" 
                       placeholder="Digite o nome do cliente..." 
                       value="<?php echo htmlspecialchars($pesquisa);?>">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i> Buscar
                </button>
            </div>
        </form>

        <?php if (!empty($pesquisa)) :?>
            
            <?php if (count($busca) > 0) :?>
                
                <h2 class="h4">Resultados para "<?php echo htmlspecialchars($pesquisa); ?>"</h2>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Cliente Desde</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            ?>
                            <?php foreach ($busca as $cliente) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                                    <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                                    <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
                                    <td>
                                        <?php 
                                        // Formata a data para um formato mais legível (ex: 24/10/2025)
                                        echo date_create($cliente['criado_em'])->format('d/m/Y H:i'); 
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php else : ?>

                <div class="alert alert-warning" role="alert">
                    Nenhum <?php echo htmlspecialchars($tipo)?> encontrado com o nome "<?php echo htmlspecialchars($pesquisa); ?>".
                </div>

            <?php endif; ?>

        <?php else: ?>
            
            <div class="alert alert-info" role="alert">
                Por favor, digite um nome no campo de busca acima para ver os resultados.
            </div>

        <?php endif; ?>

    </div> <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


