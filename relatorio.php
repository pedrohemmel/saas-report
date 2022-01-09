<?php

session_start();

if(!$_SESSION['logged']) {
    header('Location:index.php');
    exit;
} 

require 'config.php';
require 'dao/RelatorioUsuariosDaoMysql.php';


/*AQUI FOI PESQUISADO O NOME DO USUARIO PARA COLOCAR NA TELA*/
$RelatorioUsuariosDao = new RelatorioUsuariosDaoMysql($pdo);

$relatorioUsuario = $RelatorioUsuariosDao->findAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios</title>
    <!--BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!--ARQUIVO CSS-->
    <link rel="stylesheet" href="assets/style/base.css"/>
    <link rel="stylesheet" href="assets/style/relatorio.css"/>
    <!--FONTE MARCELLUS-SC-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Marcellus+SC&display=swap" rel="stylesheet">
</head>
<body>
    <header class="topBar background-primary-color">
        <div class="container">
            <img width="50px" src="assets/img/logoSaas.svg">
            <a class="background-secondary-color noDecorations submit-padding-exit color-white border-radius-button link-color-white" href="login.php?msg=<?=$_SESSION['msg'];?>">Sair <i class="bi bi-box-arrow-right bi-margin-exit color-white"></i></a>
        </div>
        
    </header>
    
    <div class="container">
        <div class="conecUsu fundoBemVindo">
           <p class="color-white">Bem vindo, <?=$_SESSION['nome'];?>!</p> 
           <p class="color-white">Seu acesso ao relatório expira na data: <?=$_SESSION['dataLimite'];?></p>
        </div>
        
        <br>

        <?php
        foreach($relatorioUsuario as $getRelatorio):
        ?>
        <iframe width="100%" height="700px;" src="<?=$getRelatorio->getLinkRel();?>"></iframe>
        <?php
        endforeach;
        ?>  
        <br>
    </div>
    
</body>
</html>
