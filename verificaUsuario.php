<?php
require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';
require 'dao/UsuarioAdministradorDaoMysql.php';

session_start();
$_SESSION['logged'] = $_SESSION['logged'] ?? false;

date_default_timezone_set('America/Sao_Paulo');

/*Utilizarei os 2 usuarios para verificar qual dos 2 está entrando no sistema, ou se nenhum dos dois esta entrando*/
$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);
$UsuarioAdministradorDao = new UsuarioAdministradorDaoMysql($pdo);

//ERRO CASO EMAIL NAO ESTEJA CORRETO
$erroLogin = 'E-mail ou Senha incorreto';
$erroLoginCrypt = password_hash($erroLogin, PASSWORD_DEFAULT);

$email_usu = filter_input(INPUT_POST, 'email_usu', FILTER_VALIDATE_EMAIL);
$senha_usu = filter_input(INPUT_POST, 'senha_usu');
$_SESSION['email'] = $email_usu;
$_SESSION['senha'] = $senha_usu;

/*SE EXISTIR O EMAIL DIGITADO, NA TABELA usuarios_cliente, OCORRE AS AÇÕES DENTRO DESSE IF*/
if($UsuarioClienteDao->verifyRowByEmail($email_usu)) {

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

    /*DECLARO UM HORARIO ATUAL PARA COMPARAR COM HORARIO LIMITE E ALTERAR PARA ACESSO PERMITIDO OU NÃO*/
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
        $usuarioAlt->setSenhaCli($senha);
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
        $usuarioAlt->setSenhaCli($senha);
        $usuarioAlt->setDataHoraCadastro($dataHoraCadastro);
        $usuarioAlt->setSituacaoCli($acesso);
        $usuarioAlt->setDataLimiteAcesso($dataLimite);

        $UsuarioClienteDao->update($usuarioAlt);
    }

    if($_SESSION['email'] == $email && password_verify($_SESSION['senha'], $senha)) {  /*#@#@$@#$#@$ AQUI NÃO ESTÁ FUNCTIONANDO, A SENHA NAO FICA IGUAL A SENHA QUE ESTA NO BANCO*/
        $_SESSION['email'] = $email;
        $_SESSION['senha'] = $senha;
        $_SESSION['nome'] = $nome;
        $_SESSION['logged'] = true;
        header('Location:login_action.php?email='.$_SESSION['email']);
        exit;
    } else {
        header('Location:login.php?erro='.$erroLoginCrypt);
        exit;
    }

    /*SE EXISTIR O EMAIL DIGITADO, NA TABELA usuarios_administrador, OCORRE AS AÇÕES DENTRO DESSE ELSE IF*/
} else if($UsuarioAdministradorDao->verifyRowByEmail($email_usu)) {

    $usuarioAdministrador = $UsuarioAdministradorDao->findByEmail($email_usu);

    foreach($usuarioAdministrador as $getUsuario) {
        $id_adm = $getUsuario->getIdAdm();
        $nome_adm = $getUsuario->getNomeAdm();
        $email_adm = $getUsuario->getEmailAdm();
        $telefone_adm = $getUsuario->getTelefoneAdm();
        $senha_adm = $getUsuario->getSenhaAdm();
    }

    if($_SESSION['email'] == $email_adm && $senha_usu == $senha_adm) {
        $_SESSION['email'] = $email_adm;
        $_SESSION['senha'] = $senha_adm;
        $_SESSION['nome'] = $nome_adm;
        $_SESSION['logged'] = true;
        header('Location:registroUsuarios.php');
        exit;
    } else {
        header('Location:login.php?erro='.$erroLoginCrypt);
        exit;
    }

    /*SE NÃO EXISTIR O EMAIL DIGITADO EM NENHUMA TABELA, OCORRE AS AÇÕES DENTRO DESSE ELSE*/
} else {
    header('Location:login.php?erro='.$erroLoginCrypt);
    exit;
}

?>