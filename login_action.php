<?php

session_start();

require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);



$usuario = $UsuarioClienteDao->findByEmail($_SESSION['email']);

/*FOI PEGO A SITUACAO DO USUARIO PARA QUE SEJA CONFIRMADO OU NEGADO O ACESSO DO USUARIO */
foreach($usuario as $getUsuario) {
    $situacao = $getUsuario->getSituacaoCli();
}

if($_SESSION['loggedUsu'] === true) {
    if($situacao == 'ativo') {
        header('Location:relatorio.php'); 
        exit;
    } else if($situacao == 'inativo') {
        header('Location:acessoNegado.php');
        exit;
    }
} else {
    header('Location:index.php');
    exit;
}




?>