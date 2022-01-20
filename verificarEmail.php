<?php
session_start();

require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';
require 'dao/UsuarioAdministradorDaoMysql.php';

if(!$_SESSION['logged'] && !$_SESSION['admLogged']) {
    header('Location:index.php');
    exit;
}

$UsuarioAministradorDao = new UsuarioAdministradorDaoMysql($pdo);

$usuarioAdm = $UsuarioAministradorDao->findAll();

foreach($usuarioAdm as $getUsuarioAdm) {
    $nome_adm = $getUsuarioAdm->getNomeAdm();
    $telefone = $getUsuarioAdm->getTelefoneAdm();
    $email_ctt = $getUsuarioAdm->getEmailAdmCtt();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'lib/vendor/autoload.php';
$mail = new PHPMailer(true);

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);

$chave = filter_input(INPUT_GET, 'chave');

$classeNone = 'displayNone';


if(!empty($chave)) {
    if($UsuarioClienteDao->verifyRowByKey($chave)) {
        
        $usuarioCli = $UsuarioClienteDao->findByKeyPass($chave);

        $link = 'http://localhost/saas-report/verificarEmail_action.php?chave='.$chave;

        foreach($usuarioCli as $getUsuario) {
            $nome_usu = $getUsuario->getNomeCli();
            $email_usu = $getUsuario->getEmailCli();
        }

        try {
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;   
            $mail->CharSet = 'UTF-8';                 
            $mail->isSMTP();                                           
            $mail->Host       = 'smtp.mailtrap.io';                 
            $mail->SMTPAuth   = true;                               
            $mail->Username   = '8ac89040fac6e3';              
            $mail->Password   = '227792651bb216';                           
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   
            $mail->Port       = 2525; 

            $mail->AddEmbeddedImage('assets/img/logoSaas.png', 'logo_saas');

            $mail->setFrom('atendimento@mailtrap.com', 'Atendimento');
            $mail->addAddress($email_usu, $nome_usu);  

            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Verificar e-mail';
            $mail->Body    = "
            Prezado(a) ".$nome_usu.". Você solicitou a verificação de email para ter acesso ao sistema.

            <br><br>

            Para continuar com o processo de verificação de email, clique no link abaixo ou cole
            o endereço no seu navegador:

            <br><br>

            <a href'".$link."'>".$link."</a>
            
            <br><br>
            
            Se você não solicitou essa verificação, nenhuma ação é necessária.

            <br><br>
            
            --
            
            <br><br>
            
            Att.
            
            <h5>".$nome_adm."</h5>
            
            Santos Assessoria | Soluções Empresariais
            
            <br><br>
            
            Endereço: Rua Exemplo de nome, 00
            
            <br><br>
            
            Tel. ".$telefone."
            
            <br><br>
            
            <img src='cid:logo_saas'>";

            $mail->AltBody = "Prezado(a) ".$nome_usu.". Você solicitou a verificação de email para ter acesso ao sistema.

            \n\n

            Para continuar com o processo de verificação de email, clique no link abaixo ou cole
            o endereço no seu navegador:

            \n\n

            ".$link."
            
            \n\n
            
            Se você não solicitou essa verificação, nenhuma ação é necessária.
            
            \n\n

            --
            
            \n\n
            
            Att.

            \n\n
            
            ".$nome_adm."

            \n\n
            
            Santos Assessoria | Soluções Empresariais
            
            \n\n
            
            Endereço: Rua Exemplo de nome, 00
            
            \n\n
            
            Tel. ".$telefone."
            
            \n\n";

            $mail->send();

            $_SESSION['msg'] = "Enviado e-mail com instruções para verificação da conta. Acesse a sua caixa de e-mail para obter a verificação!";

            $classeNone = 'displayBlkGreen';

        } catch (Exception $e) {
            $_SESSION['msg'] = "Erro: E-mail não enviado. Mailer Error: {$mail->ErrorInfo}";
            $classeNone = 'displayBlkRed';
        }  
    } else {
        header('Location:login.php');
        exit;
    }

    $mensagem = $_SESSION['msg'];
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar e-mail</title>
    <!--BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!--ARQUIVO CSS-->
    <link rel="stylesheet" href="assets/style/base.css"/>
    <link rel="stylesheet" href="assets/style/verificarEmail.css"/>
    <!--FONTE MARCELLUS-SC-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Marcellus+SC&display=swap" rel="stylesheet">
</head>
<body>
    <header class="topBar background-primary-color">
        <div class="container">
            <img width="50px" src="assets/img/logoSaas.svg">
            <a class="background-secondary-color noDecorations submit-padding-exit color-white border-radius-button link-color-white" href="login.php?msg=<?=$_SESSION['msg'];?>">Sair <i class="bi bi-box-arrow-right bi-margin-exit color-white"></i></a>
        </div>
        
    </header>
    <main class="container" id="formVerificarEmail">
        <div class="border-radius-button msgErroAcessoNegado">
            <p class="<?=$classeNone?> text-center"><?=$mensagem?></p>
            <p style="margin-bottom: 4em;">Verifique seu e-mail para ter 7 dias de acesso gratuito no sistema.</p>
            <a style="padding-left: 10px; padding-right: 10px; margin-bottom: 2em;" class="noDecorations text-hover-white border-radius-button submit-padding-top-bottom maxWidth background-primary-color border-none color-white" href="verificarEmail.php?chave=<?=$_SESSION['chave']?>">Enviar código de verificação</a>
        </div>
        
    </main>
    <footer class="background-primary-color" style="margin-top: 6em; padding: 2em;" width="100%" height="100px">
        <div class="container">
            <div class="row" style="text-align: center; ">
                <section class="col-12 col-md-6">
                    <h3>Contato</h3>
                    <br>
                    <p>Telefone: <?=$telefone;?></p>
                    <p>E-mail: <?=$email_ctt;?></p>
                </section>
                <section class="col-12 col-md-6">
                    <h3>Saas report</h3>
                    <br>
                    <p>Santos Assessoria | Soluções Empresariais</p>
                    <p>Endereço: Rua Exemplo de nome, 00</p>
                </section>
            </div>
        </div>
    </footer>
    <div class="background-primary-color" width="100%">
        <hr style="margin-top: 0; margin-bottom: 0; background-color:#000;">
        <p style="text-align: center; margin: 0; padding: 10px; color: #fff;">Copyright © 2022. All right reserved</p>
    </div>
</body>
</html>