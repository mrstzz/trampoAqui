<?php
session_start();

$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

$success = $_SESSION['success'] ?? '';
unset($_SESSION['success']);

$old_input = $_SESSION['old_input'] ?? [];
unset($_SESSION['old_input']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>trampoAqui - Bem vindo de volta!</title>
    <link rel="stylesheet" href="../assets/css/login-page.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<style>
    .error-inline {
        color: #dc3545;
        font-size: 0.875em;
        display: block;
    }
    .success_inline {
        color: green;
        font-size: 0.875em;
        display: block;
    }
</style>
<body>
    <div class="left-head"></div>
    <div class="right-head">
        
    <form class="cadastro-box" action="../auth/loginSubmit.php" method="POST">
        <?php if (isset($success['success'])): ?> 
            <div class="success_inline"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <img src="../assets/images/logo-trampo-aqui.png" alt="">
        <div class="input-box">
            <p>Email</p>
            <input type="text" name="email" placeholder=" Insira seu e-mail..." value="<?= htmlspecialchars($old_input['email'] ?? '') ?>">
        </div>

        <div class="input-box">
            <p>Senha</p>
            <input type="password" name="senha" placeholder=" Digite sua senha...">
        </div>
        
        <?php if (isset($errors['input'])): ?> 
            <div class="error-inline"><?= $errors['input'] ?></div>
        <?php endif; ?>

        <button type="submit">Entrar</button>
        
        <a href="registrar.php">Criar uma Conta</a>
    </form>
        



    </div>
</body>
</html>