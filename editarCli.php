<?php

session_start();

if(!$_SESSION['logged'] && !$_SESSION['admLogged']) {
    header('Location:index.php');
    exit;
}

require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);

$id_cli = filter_input(INPUT_GET, 'id');
$erro = filter_input(INPUT_GET, 'erro');

$_SESSION['id_cli'] = $id_cli;

if(!empty($erro)) {
    if(password_verify($_SESSION['erroEdit'], $erro)) {
        print_r($_SESSION['erroEdit']);
    }
}

if($UsuarioClienteDao->verifyRowById($_SESSION['id_cli'])) {
    $usuario = $UsuarioClienteDao->findById($_SESSION['id_cli']);

    foreach($usuario as $getUsuario) {
        $_SESSION['nome_cli'] = $getUsuario->getNomeCli();
        $_SESSION['empresa_cli'] = $getUsuario->getEmpresaCli();
        $_SESSION['email_cli'] = $getUsuario->getEmailCli();
        $_SESSION['telefone_cli'] = $getUsuario->getTelefoneCli();
        $_SESSION['data_hora_cadastro'] = $getUsuario->getDataHoraCadastro();
        $_SESSION['data_limite_acesso'] = $getUsuario->getDataLimiteAcesso();
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuario</title>
</head>
<body>
    <a href="registroUsuarios.php">Voltar</a>
    <form method="POST" action="editarCli_action.php">
        <label>Nome</label>
        <input type="text" name="nome_cli_alt" value="<?=$_SESSION['nome_cli']?>" required>
        <br><br>
        <label>Empresa</label>
        <input type="text" name="empresa_cli_alt" value="<?=$_SESSION['empresa_cli']?>" required>
        <br><br>
        <label>E-mail</label>
        <input type="text" name="email_cli_alt" value="<?=$_SESSION['email_cli']?>" required>
        <br><br>
        <label>Telefone</label>
        <input type="text" name="telefone_cli_alt" value="<?=$_SESSION['telefone_cli']?>" required>
        <br><br>
        <label>Tempo de acesso</label>
        <p style="color:gray">Digite a quantidade de dias de acesso que deseja liberar para esse usuário</p>
        <input type="number" name="data_limite_acesso_alt" min="0" max="365" >
        <br><br>
        <input type="checkbox" name="retirarAcesso">
        <label>Desejo tirar o acesso desse usuário ao meu conteúdo</label>
        <br><br>
        <input type="submit" value="Alterar">
    </form>
</body>
</html>


