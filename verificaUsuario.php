<?php
require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

date_default_timezone_set('America/Sao_Paulo');

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);

$email_cli = filter_input(INPUT_POST, 'email_cli', FILTER_VALIDATE_EMAIL);
$senha_cli = filter_input(INPUT_POST, 'senha_cli');


$usuario = $UsuarioClienteDao->findByEmail($email_cli);


foreach($usuario as $getUsuario) {
    $id = $getUsuario->getIdCli();
    $nome = $getUsuario->getNomeCli();
    $empresa = $getUsuario->getEmpresaCli();
    $email = $getUsuario->getEmailCli();
    $telefone = $getUsuario->getTelefoneCli();
    $senha = $getUsuario->getSenhaCli();
    $dataHoraCadastro = $getUsuario->getDataHoraCadastro();
    $dataLimite = $getUsuario->getDataLimiteAcesso();
}

$dataAtual = date('Y/m/d H:i:s');


if(strtotime($dataAtual) >= strtotime($dataLimite)) {
    $acesso = 'inativo';
    $usuarioAlt = new UsuarioCliente;
    $usuarioAlt->setIdCli($id);
    $usuarioAlt->setNomeCli($nome);
    $usuarioAlt->setEmpresaCli($empresa);
    $usuarioAlt->setEmailCli($email);
    $usuarioAlt->setTelefoneCli($telefone);
    $usuarioAlt->setDataHoraCadastro($dataHoraCadastro);
    $usuarioAlt->setSituacaoCli($acesso);
    $usuarioAlt->setDataLimiteAcesso($dataLimite);

    $UsuarioClienteDao->update($usuarioAlt);

    
} else if(strtotime($dataLimite) >= strtotime($dataAtual)) {
    $acesso = 'ativo';
    $usuarioAlt = new UsuarioCliente;
    $usuarioAlt->setIdCli($id);
    $usuarioAlt->setNomeCli($nome);
    $usuarioAlt->setEmpresaCli($empresa);
    $usuarioAlt->setEmailCli($email);
    $usuarioAlt->setTelefoneCli($telefone);
    $usuarioAlt->setDataHoraCadastro($dataHoraCadastro);
    $usuarioAlt->setSituacaoCli($acesso);
    $usuarioAlt->setDataLimiteAcesso($dataLimite);

    $UsuarioClienteDao->update($usuarioAlt);
}

if(password_verify($senha_cli, $senha)) {  /*#@#@$@#$#@$ AQUI NÃO ESTÁ FUNCTIONANDO, A SENHA NAO FICA IGUAL A SENHA QUE ESTA NO BANCO*/
    header('Location:login_action.php?email='.$email);
    exit;
} else {
    header('Location:login_action.php?email='.$email);
    exit;
}



?>