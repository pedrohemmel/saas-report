<?php
require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

/*AQUI FOI PESQUISADO O NOME DO USUARIO PARA COLOCAR NA TELA*/
$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);

$id_cli = filter_input(INPUT_GET, 'id');


$usuario = $UsuarioClienteDao->findById($id_cli);

foreach($usuario as $getUsuario) {
    $nome = $getUsuario->getNomeCli();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Bem vindo, <?=$nome?></p>
</body>
</html>