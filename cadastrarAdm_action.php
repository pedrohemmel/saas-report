<?php
require 'config.php';
require 'dao/UsuarioAdministradorDaoMysql.php';

$UsuarioAdministradorDao = new UsuarioAdministradorDaoMysql($pdo);

$nome_adm = filter_input(INPUT_POST, 'nome_adm');
$telefone_adm = filter_input(INPUT_POST, 'telefone_adm');
$email_adm = filter_input(INPUT_POST, 'email_adm', FILTER_VALIDATE_EMAIL);
$confirm_email_adm = filter_input(INPUT_POST, 'confirm_email_adm', FILTER_VALIDATE_EMAIL);
$senha_adm = filter_input(INPUT_POST, 'senha_adm');
$confirm_senha_adm = filter_input(INPUT_POST, 'confirm_senha_adm');


/*SE A SENHA E O EMAIL FOR IGUAL A CONFIRMAÇÃO DOS MESMOS, É CRIADO A CONTA E REDIRECIONADO PARA TELA DE LOGIN*/
if($email_adm == $confirm_email_adm && $senha_adm == $confirm_senha_adm) {
    $novoAdministrador = new UsuarioAdministrador;
    $novoAdministrador->setNomeAdm($nome_adm);
    $novoAdministrador->setTelefoneAdm($telefone_adm);
    $novoAdministrador->setEmailAdm($email_adm);
    $novoAdministrador->setSenhaAdm($senha_adm);
    

    $UsuarioAdministradorDao->add($novoAdministrador);

    header('Location:index.php');
    exit;   
} else {
    header('Location:cadastrarAdm.php');
    exit;
}
?>