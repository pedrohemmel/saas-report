<?php

session_start();

if($_SESSION['loggedAdm'] === false) {
    header('Location:index.php');
    exit;
}

require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);

$id_cli = filter_input(INPUT_GET, 'id');

$_SESSION['verMais'] = 'verMaisNone';

$UsuarioClienteDao->delete($id_cli);

header('Location:registroUsuarios.php');
exit;
?>