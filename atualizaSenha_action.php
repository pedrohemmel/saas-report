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
        

        foreach($usuario as $getUsuario) {
            $id_cli = $getUsuario->getIdCli();
        }

        $usuarioAlt = new UsuarioCliente;
        $usuarioAlt->setIdCli($id_cli);
        $usuarioAlt->setSenhaCli($nova_senha_cli);
        $UsuarioClienteDao->updateNovaSenha($usuarioAlt);

        $novaChave = password_hash("recuperado", PASSWORD_DEFAULT);

        $chaveVerificacao = new UsuarioCliente;
        $chaveVerificacao->setIdCli($id_cli);
        $chaveVerificacao->setRecuperaSenhaCli($novaChave);

        //Utilizei essa função porque o código de identificação será o mesmo
        $UsuarioClienteDao->updateRecuperarSenha($chaveVerificacao);

        $_SESSION['chaveRe'] = "Senha atualizada com sucesso!";
        $chaveRe = password_hash($_SESSION['chaveRe'], PASSWORD_DEFAULT);
        header('Location:login.php?chaveRe='.$chaveRe);
        exit;
    } else {
        $_SESSION['chaveRe'] = "Senha atualizada com sucesso!";
        $chaveRe = password_hash($_SESSION['chaveRe'], PASSWORD_DEFAULT);

        header('Location:login.php?chaveRe='.$chaveRe);
        exit;
    }
} else {
    header('Location:atualizarSenha.php'.$_SESSION['chave']);
    exit;
}



?>