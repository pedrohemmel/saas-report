<?php

session_start();

if(!$_SESSION['loggedAdm']) {
    header('Location:index.php');
    exit;
}

require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);

$id_cli = filter_input(INPUT_GET, 'id');
$erro = filter_input(INPUT_GET, 'erro');

$_SESSION['id_cli'] = $id_cli;

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

$_SESSION['editar'] = 'editarBlock';
$_SESSION['verMais'] = 'verMaisNone';

header('Location:registroUsuarios.php');
exit;
?>



