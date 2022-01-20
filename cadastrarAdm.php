<?php

session_start();

if(!$_SESSION['admCadastro']) {
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
    <title>Cadastrar administrador</title>
    <!--BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!--ARQUIVO CSS-->
    <link rel="stylesheet" href="assets/style/base.css"/>
    <link rel="stylesheet" href="assets/style/cadastrarAdm.css"/>
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
    <div class="container" id="containerCadastrarAdm">
        <section class="border-radius-button formBase" id="formCadastrarAdm">
            <!--Criando um formulário com action para o cadastrar_action.php que vai confirmar os dados e subir pro banco de dados
            como um registro-->
            <form method="POST" action="cadastrarAdm_action.php">
                <input class="inputAlt maxWidth" type="text" name="nome_adm" placeholder="Digite o nome de usuário administrador" required>

                <br><br>

                <input class="inputAlt maxWidth" type="tel" name="telefone_adm" placeholder="Digite seu telefone" minlength="11" maxlength="11" required>

                <br><br>

                <input class="inputAlt maxWidth" type="email" name="email_adm_ctt" placeholder="Digite seu e-mail de contato/suporte" required>

                <br><br>

                <div class="row">
                    <div class="col-12 col-md-6">
                        <input class="inputAlt maxWidth" type="email" name="email_adm" placeholder="Digite seu e-mail de acesso" required>

                        <br><br>
                    </div>
                    <div class="col-12 col-md-6">
                        <input class="inputAlt maxWidth" type="email" name="confirm_email_adm" placeholder="Confirme seu e-mail de acesso" required>

                        <br><br>
                    </div>
                    <div class="col-12 col-md-6">
                        <input class="inputAlt maxWidth" type="password" name="senha_adm" placeholder="Digite sua senha" required>

                        <br><br>
                    </div>
                    <div class="col-12 col-md-6">
                        <input class="inputAlt maxWidth" type="password" name="confirm_senha_adm" placeholder="Confirme sua senha" required>

                        <br><br>
                    </div>
                </div>
                
                <input class="border-radius-button submit-padding-top-bottom maxWidth background-primary-color border-none color-white" type="submit" value="Cadastrar">
            </form>
        </section> 
    </div>

</body>
</html>