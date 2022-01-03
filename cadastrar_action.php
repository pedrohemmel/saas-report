<?php

session_start();

require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

date_default_timezone_set('America/Sao_Paulo');

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);

$nome_cli = filter_input(INPUT_POST, 'nome_cli');
$empresa_cli = filter_input(INPUT_POST, 'empresa_cli');
$telefone_cli = filter_input(INPUT_POST, 'telefone_cli');
$email_cli = filter_input(INPUT_POST, 'email_cli', FILTER_VALIDATE_EMAIL);
$confirm_email_cli = filter_input(INPUT_POST, 'confirm_email_cli', FILTER_VALIDATE_EMAIL);
$senha_cli = filter_input(INPUT_POST, 'senha_cli');
$confirm_senha_cli = filter_input(INPUT_POST, 'confirm_senha_cli');
$data_hora_cadastro = date('Y/m/d H:i:s');
$situacao_cli = 'ativo';
$data_limite_acesso = date('Y/m/d H:i:s', strtotime('+7 days')); //ADICIONEI MAIS 7 DIAS QUE SERIA O TEMPO GRATUITO DO USUARIO



/*SE A SENHA E O EMAIL FOR IGUAL A CONFIRMAÇÃO DOS MESMOS, É CRIADO A CONTA E REDIRECIONADO PARA TELA DE LOGIN*/
if($nome_cli && $empresa_cli && $telefone_cli && $email_cli && $confirm_email_cli && $senha_cli && $confirm_senha_cli && $data_hora_cadastro && $situacao_cli && $data_limite_acesso) {
    if($email_cli === $confirm_email_cli && $senha_cli === $confirm_senha_cli) {
        if($UsuarioClienteDao->verifyRowByEmail($email_cli)) {

            //variaveis de erro caso cadastro não esteja correto
            $_SESSION['erroCadastro'] = '<p style="color:#f00">Alguem já está utilizando esse email.</p>';
            $erroCadastroCrypt = password_hash($_SESSION['erroCadastro'], PASSWORD_DEFAULT);

            header('Location:cadastrar.php?erro='.$erroCadastroCrypt);
            exit;

        } else {

            $senhaCrypt = password_hash($senha_cli, PASSWORD_DEFAULT);

            $novoCliente = new UsuarioCliente;
            $novoCliente->setNomeCli($nome_cli);
            $novoCliente->setEmpresaCli($empresa_cli);
            $novoCliente->setTelefoneCli($telefone_cli);
            $novoCliente->setEmailCli($email_cli);
            $novoCliente->setSenhaCli($senhaCrypt);
            $novoCliente->setDataHoraCadastro($data_hora_cadastro);
            $novoCliente->setSituacaoCli($situacao_cli);
            $novoCliente->setDataLimiteAcesso($data_limite_acesso);

            $UsuarioClienteDao->add($novoCliente);

            header('Location:index.php');
            exit;  
        }
    } else {
        //variaveis de erro caso cadastro não esteja correto
        $_SESSION['erroCadastro'] = '<p style="color:#f00">Dados foram inseridos incorretamente.</p>';
        $erroCadastroCrypt = password_hash($erroCadastro, PASSWORD_DEFAULT);

        header('Location:cadastrar.php?erro='.$erroCadastroCrypt);
        exit;
    }
} else {
    $_SESSION['erroCadastro'] = '<p style="color:#f00">Dados foram inseridos incorretamente.</p>';
    $erroCadastroCrypt = password_hash($erroCadastro, PASSWORD_DEFAULT);

    header('Location:cadastrar.php?erro='.$erroCadastroCrypt);
    exit;
}

?>