<?php
session_start();

if (isset($_POST['perfil'])) {
    $perfil = $_POST['perfil'];

    $_SESSION['perfil'] = $perfil;
    header("Location: ../pages/auth/registrar.php"); 
    exit();
} else {
    header("Location: ../pages/auth/cliente_comerciante.php");
    exit();
}
