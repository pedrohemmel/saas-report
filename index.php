<?php
require 'config.php';
require 'dao/UsuarioAdministradorDaoMysql.php';

session_start();

$UsuarioAdministradorDao = new UsuarioAdministradorDaoMysql($pdo);

if($UsuarioAdministradorDao->verifyRow()) {
    $_SESSION['admCadastro'] = false;
    header('Location:login.php');
    exit;
} else {
    $_SESSION['admCadastro'] = true;
    header('Location:cadastrarAdm.php');
    exit;
}



?>