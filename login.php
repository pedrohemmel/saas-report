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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <form method="POST" action="verificaUsuario.php"> <!--ENVIA OS DADOS PARA VERIFICAR SE ESSE USUARIO EXISTE E SE ELE TEM ACESSO AO RELATORIO-->
        <label>E-mail</label>
        <input type="text" name="email_usu" placeholder="Digite o email" required>

        <br><br>

        <label>Senha</label>
        <input type="password" name="senha_usu" placeholder="Digite sua senha" required>

        <input type="submit" value="Acessar">
    </form>
    <a href="recuperarSenha.php">Esqueceu a senha?</a>
    <p>Não tem conta? Clique <a href="cadastrar.php">aqui</a> e se cadastre agora.</p>
</body>
</html>