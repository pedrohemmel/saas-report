<?php
require 'config.php';
require 'dao/UsuarioAdministradorDaoMysql.php';

$UsuarioAdministradorDao = new UsuarioAdministradorDaoMysql($pdo);

$usuarioAdm = $UsuarioAdministradorDao->findAll();



if($usuarioAdm->rowCount() > 0) {
    header('Location:login.php');
} else {
    header('Location:cadastrarAdm.php');
}



?>