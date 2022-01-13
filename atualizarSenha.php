<?php

session_start();

require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);

//CASO O LINK PARA ACESSAR A SENHA ESTIVER ERRADO
$erroAtualizaSenha = 'Erro ao acessar página, solicite um novo link';
$erroAtualizaSenhaCrypt = password_hash($erroAtualizaSenha, PASSWORD_DEFAULT);

$_SESSION['chave'] = filter_input(INPUT_GET, 'chave');

if($UsuarioClienteDao->verifyRowByKey($_SESSION['chave'])) {
    $usuarioPorChave = $UsuarioClienteDao->findByKeyPass($_SESSION['chave']);

    foreach($usuarioPorChave as $getUsuario) {
        $nomeCli = $getUsuario->getNomeCli();
        $chaveCli = $getUsuario->getRecuperaSenhaCli();
    }
} else {
    header('Location:recuperarSenha.php?erro='.$erroAtualizaSenhaCrypt);
    exit;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--ARQUIVO CSS-->
    <link rel="stylesheet" href="assets/style/base.css"/>
    <link rel="stylesheet" href="assets/style/cadastrar.css"/>
    <!--FONTE MARCELLUS-SC-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Marcellus+SC&display=swap" rel="stylesheet">
</head>
<body>
    <header class="topBar background-primary-color">
        <div class="container">
            <img width="50px" src="assets/img/logoSaas.svg">
        </div>
    </header>
    <div class="container" id="containerCadastrar">
        <section class="border-radius-button formBase" id="formCadastrar">
            <form method="POST" action="atualizaSenha_action.php">
                
                <input class="inputAlt maxWidth" type="password" name="nova_senha_cli" placeholder="Digite sua nova senha" required>

                <br><br>

                <input class="border-radius-button submit-padding-top-bottom maxWidth background-primary-color border-none color-white" type="submit" value="Alterar senha">
            </form>
        </section>
    </div>
    
</body>
</html>