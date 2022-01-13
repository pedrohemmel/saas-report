<?php

session_start();

require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);

$chave = filter_input(INPUT_GET, 'chave');

if(!empty($chave)) {
    if($UsuarioClienteDao->verifyRowByKey($chave)) {

        $usuarioCli = $UsuarioClienteDao->findByKeyPass($chave);

        foreach($usuarioCli as $getUsuario) {
            $id = $getUsuario->getIdCli();
            $verificacao_cli = 'sim';
        }

        $usuario_verificado = new UsuarioCliente;
        $usuario_verificado->setIdCli($id);
        $usuario_verificado->setVerificacaoCli($verificacao_cli);
        $UsuarioClienteDao->updateVerificacao($usuario_verificado);

        $novaChave = password_hash("verificado", PASSWORD_DEFAULT);

        $chaveVerificacao = new UsuarioCliente;
        $chaveVerificacao->setIdCli($id);
        $chaveVerificacao->setRecuperaSenhaCli($novaChave);

        //Utilizei essa função porque o código de identificação será o mesmo
        $UsuarioClienteDao->updateRecuperarSenha($chaveVerificacao);

        $_SESSION['msgVeri'] = 'Seu e-mail foi verificado com sucesso!';
        $msgVeri = password_hash($_SESSION['msgVeri'], PASSWORD_DEFAULT);

        header('Location:login.php?msgVeri='.$msgVeri);
        exit;
    } else {
        $_SESSION['chaveVeri'] = 'O link de verificação da conta está incorreto ou já foi utilizado.';
        $chaveVeri = password_hash($_SESSION['chaveVeri'], PASSWORD_DEFAULT);

        header('Location:login.php?chaveVeri='.$chaveVeri);
        exit;
    }
} else {
    $_SESSION['chaveVeri'] = 'O link de verificação da conta está incorreto ou já foi utilizado.';
    $chaveVeri = password_hash($_SESSION['chaveVeri'], PASSWORD_DEFAULT);

    header('Location:login.php?chaveVeri='.$chaveVeri);
    exit;
}


?>