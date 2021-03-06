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

$erroCadastroCrypt = filter_input(INPUT_GET, 'erro');

$classeNone = 'displayNone';

if(!empty($erroCadastroCrypt)) {
    if(password_verify($_SESSION['erroCadastro'], $erroCadastroCrypt)) {
        $classeNone = 'displayBlkRed';
        $_SESSION['msg'] = $_SESSION['erroCadastro'];
    }
}

$mensagem = $_SESSION['msg'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar usuário</title>
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
        <section class="border-radius-button formBase" id="formCadastrar" style="margin-top: 4em;">
    <!--Criando um formulário com action para o cadastrar_action.php que vai confirmar os dados e subir pro banco de dados
como um registro-->
            <form method="POST" action="cadastrar_action.php">
                <p class="<?=$classeNone?> text-center"><?=$mensagem?></p>

                <input class="inputAlt maxWidth" type="text" name="nome_cli" placeholder="Digite seu nome completo" required>
                <br><br>
                <input class="inputAlt maxWidth" type="text" name="empresa_cli" placeholder="Digite sua empresa" required>
                <br><br>
                <input class="inputAlt maxWidth" type="tel" name="telefone_cli" placeholder="Digite seu telefone" minlength="11" maxlength="11" required>
                <br><br>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <input class="inputAlt maxWidth" type="email" name="email_cli" placeholder="Digite seu e-mail" required>
                        <br><br>
                    </div>
                    <div class="col-12 col-md-6">
                        <input class="inputAlt maxWidth" type="email" name="confirm_email_cli" placeholder="Confirme seu e-mail" required>
                        <br><br>
                    </div>
                    <div class="col-12 col-md-6">
                        <input class="inputAlt maxWidth" type="password" name="senha_cli" placeholder="Digite sua senha" required>
                        <br><br>
                    </div>
                    <div class="col-12 col-md-6">
                        <input class="inputAlt maxWidth" type="password" name="confirm_senha_cli" placeholder="Confirme sua senha" required>
                        <br><br>
                    </div>
                </div>
                <input class="border-radius-button submit-padding-top-bottom maxWidth background-primary-color border-none color-white" type="submit" value="Cadastrar">
            </form>
            <br>
            <hr>
            <a class="noDecorations color-primary text-center link-color-primary" href="login.php">Fazer login</a>
        </section>
    </div>

    <footer class="background-primary-color" style="margin-top: 4em; padding: 2em;" width="100%" height="100px">
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