<?php

session_start();

require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);

$usuario = $UsuarioClienteDao->findByKeyPass($_SESSION['chave']);

foreach($usuario as $getUsuario) {
    $senha_cli = $getUsuario->getSenhaCli();
}

$nova_senha = filter_input(INPUT_POST, 'nova_senha_cli');
if($nova_senha) {
    if(!password_verify($nova_senha, $senha_cli)) {
        $nova_senha_cli = password_hash($nova_senha, PASSWORD_DEFAULT);

        $usuario = $UsuarioClienteDao->findByKeyPass($_SESSION['chave']);
        $_SESSION['chaveRe'] = "<p style='color:green'>Senha atualizada com sucesso!</p>";

        foreach($usuario as $getUsuario) {
            $id_cli = $getUsuario->getIdCli();
        }


        $usuarioAlt = new UsuarioCliente;
        $usuarioAlt->setIdCli($id_cli);
        $usuarioAlt->setSenhaCli($nova_senha_cli);
        $UsuarioClienteDao->updateNovaSenha($usuarioAlt);

        header('Location:login.php?chaveRe='.$_SESSION['chaveRe']);
        exit;
    } else {
        $_SESSION['chaveRe'] = "<p style='color:green'>Senha atualizada com sucesso!</p>";

        header('Location:login.php?chaveRe='.$_SESSION['chaveRe']);
        exit;
    }
} else {
    header('Location:atualizarSenha.php'.$_SESSION['chave']);
    exit;
}



?>