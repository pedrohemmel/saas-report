<?php
require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);

$email_cli = filter_input(INPUT_GET, 'email');

$usuario = $UsuarioClienteDao->findByEmail($email_cli);


foreach($usuario as $getUsuario) {
    $id = $getUsuario->getIdCli();
    $nome = $getUsuario->getNomeCli();
    $empresa = $getUsuario->getEmpresaCli();
    $email = $getUsuario->getEmailCli();
    $telefone = $getUsuario->getTelefoneCli();
    $senha = $getUsuario->getSenhaCli();
    $situacao = $getUsuario->getSituacaoCli();
    $dataHoraCadastro = $getUsuario->getDataHoraCadastro();
    $dataLimite = $getUsuario->getDataLimiteAcesso();
}


if($situacao == 'ativo') {
    header('Location:relatorio.php?id='.$id); 
    exit;
} else if($situacao == 'inativo') {
    header('Location:acessoNegado.php');
    exit;
}



?>