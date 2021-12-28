<?php

session_start();

require 'config.php';
require 'dao/RelatorioUsuariosDaoMysql.php';


/*AQUI FOI PESQUISADO O NOME DO USUARIO PARA COLOCAR NA TELA*/
$RelatorioUsuariosDao = new RelatorioUsuariosDaoMysql($pdo);

$relatorioUsuario = $RelatorioUsuariosDao->findAll();

if(!$_SESSION['logged']) {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <p>Bem vindo, <?=$_SESSION['nome'];?></p>

    <a href="login.php?msg=<?=$_SESSION['msg'];?>">Logout</a>

    <?php
    foreach($relatorioUsuario as $getRelatorio):
    ?>
    <iframe width="80%;" height="700px" src="<?=$getRelatorio->getLinkRel();?>" title="Apple Developer Academy"></iframe>
    <?php
    endforeach;
    ?>
</body>
</html>
