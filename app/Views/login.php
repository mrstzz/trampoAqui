<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>trampoAqui - Entre como Usuário</title>
    <link rel="stylesheet" href="/css/login-page.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:..." rel="stylesheet">
</head>
<body>
    <div class="left-head"></div>
    <div class="right-head">

        <form class="cadastro-box" action="/login" method="POST">

            <img src="/images/logo-trampo-aqui.png" alt="">

             <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
             <?php if (isset($success)): ?>
                <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>


            <div class="input-box">
                <p>Email</p>
                 <input type="text" name="email" placeholder="Entre com seu usuário..." value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </div>

            <div class="input-box">
                <p>Senha</p>
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha...">
            </div>

            <div class="check-senha">
                <div class="checkbox-input">
                    <input type="checkbox" name="lembrar"> <p>Lembrar minha senha</p>
                </div>
                <a href="/esqueci-senha">Esqueci minha senha</a> </div>
            <button type="submit">Entrar</button>

            <a href="/signup">Criar uma Conta</a> </form>
    </div>
</body>
</html>