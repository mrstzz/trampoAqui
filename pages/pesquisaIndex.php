<?php

include_once "../Classes/Conexao.php";
include_once "../Classes/Cliente.php";


extract($_POST);


if (empty($pesquisa)) {
    header("Location: ../index.php?msg=slslaask");
    exit;
}
