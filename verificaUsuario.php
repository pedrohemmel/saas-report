<?php
require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';
require 'dao/UsuarioAdministradorDaoMysql.php';

date_default_timezone_set('America/Sao_Paulo');

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);
$UsuarioAdministradorDao = new UsuarioAdministradorDaoMysql($pdo);

$email_usu = filter_input(INPUT_POST, 'email_usu', FILTER_VALIDATE_EMAIL);
$senha_usu = filter_input(INPUT_POST, 'senha_usu');


if($UsuarioClienteDao->findByEmail($email_usu)) {

    $usuario = $UsuarioClienteDao->findByEmail($email_usu);

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

    /*SE O USUARIO NAO ESTIVER DENTRO DO TEMPO DE ACESSO, OCORRE UM UPDATE PARA DEIXAR A situacao_cli INATIVA*/
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

    if($email_usu == $email && password_verify($senha_usu, $senha)) {  /*#@#@$@#$#@$ AQUI NÃO ESTÁ FUNCTIONANDO, A SENHA NAO FICA IGUAL A SENHA QUE ESTA NO BANCO*/
        header('Location:login_action.php?email='.$email);
        exit;
    } else {
        echo 'senha ainda n ta certa';
    }

} else if($UsuarioAdministradorDao->findByEmail($email_usu)) {
    $usuarioAdministrador = $UsuarioAdministradorDao->findByEmail($email_usu);

    foreach($usuarioAdministrador as $getUsuario) {
        $id_adm = $getUsuario->getIdAdm();
        $nome_adm = $getUsuario->getNomeAdm();
        $email_adm = $getUsuario->getEmailAdm();
        $telefone_adm = $getUsuario->getTelefoneAdm();
        $senha_adm = $getUsuario->getSenhaAdm();
    }

    if($email_usu == $email_adm && password_verify($senha_usu, $senha_adm)) {
        header('Location:usuAdm.php');
    }

} else {
    header('Location:login.php');
    exit;
}
 






?>