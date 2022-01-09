<?php
session_start();

if(!$_SESSION['logged'] && !$_SESSION['admLogged']) {
    header('Location:index.php');
    exit;
}


require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);


$email = $_SESSION['email_cli'];
$telefone = $_SESSION['telefone_cli'];


$nome_cli = filter_input(INPUT_POST, 'nome_cli_alt');
$empresa_cli = filter_input(INPUT_POST, 'empresa_cli_alt');
$email_cli = filter_input(INPUT_POST, 'email_cli_alt');
$telefone_cli = filter_input(INPUT_POST, 'telefone_cli_alt');
$tempo_adicionado_cli = filter_input(INPUT_POST, 'data_limite_acesso_alt');
$retirarAcesso = filter_input(INPUT_POST, 'retirarAcesso');

$dataAtual = date('Y/m/d H:i:s');
$tempo_adicionado = date('Y/m/d H:i:s', strtotime('+'.$tempo_adicionado_cli.' days'));

if($nome_cli && $empresa_cli && $email_cli && $telefone_cli) {
    if((($UsuarioClienteDao->verifyRowByEmail($email_cli) && ($email_cli === $email)) && ($UsuarioClienteDao->verifyRowByPhone($telefone_cli) && ($telefone_cli === $telefone))) || 
    (($UsuarioClienteDao->verifyRowByEmail($email_cli) && ($email_cli === $email)) && (!$UsuarioClienteDao->verifyRowByPhone($telefone_cli) && ($telefone_cli != $telefone))) || 
    ((!$UsuarioClienteDao->verifyRowByEmail($email_cli) && ($email_cli != $email)) && ($UsuarioClienteDao->verifyRowByPhone($telefone_cli) && ($telefone_cli === $telefone))) || 
    ((!$UsuarioClienteDao->verifyRowByEmail($email_cli) && ($email_cli != $email)) && (!$UsuarioClienteDao->verifyRowByPhone($telefone_cli) && ($telefone_cli != $telefone)))) {
        
        if(!$retirarAcesso) {

            if($tempo_adicionado_cli == 0 or empty($tempo_adicionado_cli)) {

                $data_limite_acesso = $_SESSION['data_limite_acesso'];

            } else {

                if(strtotime($dataAtual) > strtotime($_SESSION['data_limite_acesso'])) {

                    $data_limite_acesso = $tempo_adicionado;

                } else if(strtotime($dataAtual) < strtotime($_SESSION['data_limite_acesso'])) {

                    $data_limite_acesso = date('Y/m/d H:i:s', strtotime('+'.$tempo_adicionado_cli.'days', strtotime($_SESSION['data_limite_acesso'])));

                }
                
            }  

        } else {

            $data_limite_acesso = date('Y/m/d H:i:s', strtotime('-1 days'));

        }

        $usuarioAlt = new UsuarioCliente;
        $usuarioAlt->setIdCli($_SESSION['id_cli']);
        $usuarioAlt->setNomeCli($nome_cli);
        $usuarioAlt->setEmpresaCli($empresa_cli);
        $usuarioAlt->setEmailCli($email_cli);
        $usuarioAlt->setTelefoneCli($telefone_cli);
        $usuarioAlt->setDataLimiteAcesso($data_limite_acesso);

        $UsuarioClienteDao->update($usuarioAlt);

        //Atualizar status

        $usuarioCliAlt = $UsuarioClienteDao->findById($_SESSION['id_cli']);  

        foreach($usuarioCliAlt as $getNewUsuario) {
            $id_cli = $getNewUsuario->getIdCli();
            $status = $getNewUsuario->getSituacaoCli();
            $dataHoraCadastro = $getNewUsuario->getDataHoraCadastro();
            $dataLimiteAcesso = $getNewUsuario->getDataLimiteAcesso();
        }

        $dataAtual = date('Y/m/d H:i:s');

        if(strtotime($dataLimiteAcesso) <= strtotime($dataAtual) && $status === 'ativo') {
            $acesso = 'inativo';
            $usuarioAlt = new UsuarioCliente;
            $usuarioAlt->setIdCli($id_cli);
            $usuarioAlt->setSituacaoCli($acesso);
            
            $UsuarioClienteDao->updateSituacao($usuarioAlt);

        } else if(strtotime($dataLimiteAcesso) >= strtotime($dataAtual) && $status === 'inativo') {
            $acesso = 'ativo';
            $usuarioAlt = new UsuarioCliente;
            $usuarioAlt->setIdCli($id_cli);
            $usuarioAlt->setSituacaoCli($acesso);
            
            $UsuarioClienteDao->updateSituacao($usuarioAlt);
        }
         

        $_SESSION['msgAlt'] = '<p style="color:green">Dados alterados com sucesso.</p>';
        $_SESSION['msgAltCrypt'] = password_hash($_SESSION['msgAlt'], PASSWORD_DEFAULT);
        header('Location:registroUsuarios.php?msg='.$_SESSION['msgAltCrypt']);
        exit;

    } else if((($UsuarioClienteDao->verifyRowByEmail($email_cli) && ($email_cli != $email)) && ($UsuarioClienteDao->verifyRowByPhone($telefone_cli) && ($telefone_cli != $telefone))) || 
            (($UsuarioClienteDao->verifyRowByEmail($email_cli) && ($email_cli != $email)) && ($UsuarioClienteDao->verifyRowByPhone($telefone_cli) && ($telefone_cli === $telefone))) ||
            (($UsuarioClienteDao->verifyRowByEmail($email_cli) && ($email_cli === $email)) && ($UsuarioClienteDao->verifyRowByPhone($telefone_cli) && ($telefone_cli != $telefone))) ||
            (($UsuarioClienteDao->verifyRowByEmail($email_cli) && ($email_cli != $email)) && (!$UsuarioClienteDao->verifyRowByPhone($telefone_cli) && ($telefone_cli != $telefone))) ||
            ((!$UsuarioClienteDao->verifyRowByEmail($email_cli) && ($email_cli != $email)) && ($UsuarioClienteDao->verifyRowByPhone($telefone_cli) && ($telefone_cli != $telefone)))) {

        $_SESSION['erroEdit'] = '<p style="color:#f00">Alguem já está utilizando os dados inseridos.</p>';
        $_SESSION['erroEditCrypt'] = password_hash($_SESSION['erroEdit'], PASSWORD_DEFAULT);
        header('Location:editarCli.php?erro='.$_SESSION['erroEditCrypt']);
        exit;

    }

} else {
    $_SESSION['erroEdit'] = '<p style="color:#f00">Os dados não foram inseridos corretamente.</p>';
    $_SESSION['erroEditCrypt'] = password_hash($_SESSION['erroEdit'], PASSWORD_DEFAULT);
    header('Location:editarCli.php?erro='.$_SESSION['erroEditCrypt']);
    exit;
}
?>