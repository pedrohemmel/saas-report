<?php

session_start();

require 'config.php';
require 'dao/UsuarioAdministradorDaoMysql.php';

$UsuarioAministradorDao = new UsuarioAdministradorDaoMysql($pdo);

$usuarioAdm = $UsuarioAministradorDao->findAll();

foreach($usuarioAdm as $getUsuarioAdm) {
    $telefone = $getUsuarioAdm->getTelefoneAdm();
    $email_ctt = $getUsuarioAdm->getEmailAdmCtt();
}

if($_SESSION['loggedUsu'] === false) {
    header('Location:index.php');
    exit;
} 
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
    
    <div class="container" style="position: relative;">
        <div>
           <p id="bemVindTop" class="background-primary-color border-radius-button color-white" style="margin: 0;">Bem vindo, <?=$_SESSION['nome'];?>! | Seu acesso ao relatório expira na data: <?=$_SESSION['dataLimite'];?></p> 

        </div>

        <div id="htmlTest" style="width: 100%;height: 80vh; margin-top: 1em;"></div>
        <div id="dhs"></div>
        <script type="text/javascript" src="assets/js/main.js"></script>

        <style>
        
        div[data-element="dhs"] {
            position: absolute;
            display: none;
            bottom: 25px;
            right: 15px;
            width: 95px;
            height: 25px;
            background-color: #eaeaea;
            z-index: 1000;
        }

        @media screen and (min-width: 768px) {
            div[data-element="dhs"] {
            position: absolute;
            display: none;
            bottom: 25px;
            right: 15px;
            width: 190px;
            height: 25px;
            background-color: #eaeaea;
            z-index: 1000;
        }
        }
        
        </style>
        <div data-element="dhs" style="display: block;"></div>
     
        <br>
    </div>
    <footer class="background-primary-color" style="margin-top: 1em; padding: 2em;" width="100%" height="100px">
        <div class="container">
            <div class="row" style="text-align: center; ">
                <section class="col-12 col-md-6">
                    <h3>Contato</h3>
                    <br>
                    <p>Telefone: <?=$telefone;?></p>
                    <p>E-mail: <?=$email_ctt;?></p>
                </section>
                <section class="col-12 col-md-6">
                    <h3>Saas report</h3>
                    <br>
                    <p>Santos Assessoria | Soluções Empresariais</p>
                    <p>Endereço: Rua Exemplo de nome, 00</p>
                </section>
            </div>
        </div>
    </footer>
    <div class="background-primary-color" width="100%">
        <hr style="margin-top: 0; margin-bottom: 0; background-color:#000;">
        <p style="text-align: center; margin: 0; padding: 10px; color: #000;">Copyright © 2022. All right reserved</p>
    </div>
</body>
</html>
