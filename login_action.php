<?php
require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);

$email_cli = filter_input(INPUT_POST, 'email_cli', FILTER_VALIDATE_EMAIL);
$senha_cli = filter_input(INPUT_POST, 'senha_cli');



$usuario = $UsuarioClienteDao->findByEmail($email_cli);


$email;
$senha;

foreach($usuario as $getUsuario) {
    $email = $getUsuario->getEmailCli();
    $senha = $getUsuario->getSenhaCli();
}

echo $email_cli;
echo $senha_cli; //FIZ ISSO PARA VER SE AS VARIAVEIS ESTAO COM VALOR
echo $senha;

if(password_verify($senha_cli, $senha)) {  /*#@#@$@#$#@$ AQUI NÃO ESTÁ FUNCTIONANDO, A SENHA NAO FICA IGUAL A SENHA QUE ESTA NO BANCO*/
    header('Location:index.php');
    exit;
} else {
  
    exit;
    
}




?>