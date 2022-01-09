<?php

session_start();


$erroCadastroCrypt = filter_input(INPUT_GET, 'erro');

if(!empty($erroCadastroCrypt)) {
        print_r($_SESSION['erroCadastro']);
}

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
        <section class="border-radius-button formBase" id="formCadastrar">
    <!--Criando um formulário com action para o cadastrar_action.php que vai confirmar os dados e subir pro banco de dados
como um registro-->
            <form method="POST" action="cadastrar_action.php">
                    <input class="inputAlt maxWidth" type="text" name="nome_cli" placeholder="Digite seu nome completo" required>
                <br><br>
                    <input class="inputAlt maxWidth" type="text" name="empresa_cli" placeholder="Digite sua empresa" required>
                <br><br>
                    <input class="inputAlt maxWidth" type="tel" name="telefone_cli" placeholder="Digite seu telefone" required>
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
</body>
</html>