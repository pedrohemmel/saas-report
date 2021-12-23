<?php
require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);

$email_cli = filter_input(INPUT_GET, 'email');

$usuario = $UsuarioClienteDao->findByEmail($email_cli);

/*FOI PEGO A SITUACAO DO USUARIO PARA QUE SEJA CONFIRMADO OU NEGADO O ACESSO DO USUARIO */
foreach($usuario as $getUsuario) {
    $id = $getUsuario->getIdCli();
    $situacao = $getUsuario->getSituacaoCli();
}


if($situacao == 'ativo') {
    header('Location:relatorio.php?id='.$id); 
    exit;
} else if($situacao == 'inativo') {
    header('Location:acessoNegado.php');
    exit;
}



?>