<?php
require 'config.php';
require 'dao/UsuarioAdministradorDaoMysql.php';

$UsuarioAdministradorDao = new UsuarioAdministradorDaoMysql($pdo);

if($UsuarioAdministradorDao->verifyRow()) {
    header('Location:login.php');
} else {
    header('Location:cadastrarAdm.php');
}



?>