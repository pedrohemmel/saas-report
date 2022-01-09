<?php
session_start();

$_SESSION['erro'] = '<p style="color:#f00">Usuário ou senha incorretos</p>';
$erroLogin = 'E-mail ou Senha incorreto';
$msgLog = 'end';
$erro = filter_input(INPUT_GET, 'erro');
$msg = filter_input(INPUT_GET, 'msg');
$chaveRe = filter_input(INPUT_GET, 'chaveRe');

if(!empty($erro)) {
    if(password_verify($erroLogin, $erro)) {
        print_r($_SESSION['erro']);
    }
} else if(!empty($msg)) {
    if(password_verify($msgLog, $msg)) {
        $_SESSION['logged'] = false;
    }
} else if(!empty($chaveRe)) {
    print_r($_SESSION['chaveRe']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!--BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--ARQUIVO CSS-->
    <link rel="stylesheet" href="assets/style/base.css"/>
    <link rel="stylesheet" href="assets/style/login.css"/>
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
    <main class="container">
        <div class="row">
            <div class="col-md-6" id="bannerLogin">
                <section class="first-banner-saas">
                    <img width="60%" src="assets/img/logoSaas.svg">
                    <p class="color-tertiary" >Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas saepe voluptate maxime quae numquam perspiciatis dolore, harum maiores in, fuga voluptatem est magnam hic? Illum impedit libero obcaecati repellat praesentium.</p>
                </section>
            </div>
            <div class="col-12 col-md-6">
                <section class="border-radius-button formBase" id="formLogin">
                    <form method="POST" action="verificaUsuario.php"> <!--ENVIA OS DADOS PARA VERIFICAR SE ESSE USUARIO EXISTE E SE ELE TEM ACESSO AO RELATORIO-->
                        <input class="inputAlt maxWidth" type="text" name="email_usu" placeholder="Digite o email" required>

                        <br><br>

                        <input class="inputAlt maxWidth" type="password" name="senha_usu" placeholder="Digite sua senha" required>

                        <br><br>

                        <input class="border-radius-button submit-padding-top-bottom maxWidth background-primary-color border-none color-white" type="submit" value="Entrar">
                    </form>

                    <br>

                    <a class="noDecorations color-primary text-center link-color-primary" href="cadastrar.php">Cadastre-se</a>

                    <hr>

                    <a class="noDecorations color-primary text-center link-color-primary" href="recuperarSenha.php">Esqueceu a senha?</a>
                </section>
            </div>
            
        </div>
        
    </main>
</body>
</html>