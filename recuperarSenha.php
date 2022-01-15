
<?php
require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'lib/vendor/autoload.php';
$mail = new PHPMailer(true);

$email_usu = filter_input(INPUT_POST, 'email_usu');
$erroAtualizaSenhaCrypt = filter_input(INPUT_GET, 'erro');

$erroAtualizaSenha = 'Erro ao acessar página, solicite um novo link';

$_SESSION['msg'] = '';

$classeNone = 'displayNone';

if(!empty($email_usu)) {
    
    $UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);

    if($UsuarioClienteDao->verifyRowByEmail($email_usu)) {

        $usuario = $UsuarioClienteDao->findByEmail($email_usu);

        foreach($usuario as $getUsuario) {
            $id = $getUsuario->getIdCli();
            $nome_usu = $getUsuario->getNomeCli();
        }  

        $chave_recuperar_senha = password_hash($id, PASSWORD_DEFAULT);

        $usuario_recuperar_senha = new UsuarioCliente;
        $usuario_recuperar_senha->setIdCli($id);
        $usuario_recuperar_senha->setRecuperaSenhaCli($chave_recuperar_senha);

        $UsuarioClienteDao->updateRecuperarSenha($usuario_recuperar_senha);
        
        $link = 'http://localhost/saas-report/atualizarSenha.php?chave='.$chave_recuperar_senha;

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

            $mail->setFrom('atendimento@mailtrap.com', 'Atendimento');
            $mail->addAddress($email_usu, $nome_usu);  

            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Recuperar senha';
            $mail->Body    = "
            

            Prezado(a) ".$nome_usu.". Você solicitou alteração de senha.

            <br><br>

            Para continuar com o processo de recuperação de sua senha, clique no link abaixo ou cole
            o endereço no seu navegador:

            <br><br>

            ".$link."
            
            <br><br>
            
            Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá
            a mesma até que você ative esse código.
            
            <br><br>
            
            --
            
            <br><br>
            
            Att.
            
            <h5>Exemplo de nome</h5>
            
            Santos Assessoria | Soluções Empresariais
            
            <br>
            
            Endereço: Rua Exemplo de nome, 00
            
            <br>
            
            Tel. (11) 2222-2222 / (11) 3333-3333
            
            <br>
            
            <img width='200px' src='assets/img/logoSaas.svg'>";
            $mail->AltBody = 'Prezado(a) '.$nome_usu.'. Você solicitou alteração de senha.

            \n\n

            Para continuar com o processo de recuperação de sua senha, clique no link abaixo ou cole
            o endereço no seu navegador:

            \n\n

            '.$link.'
            
            \n\n
            
            Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá
            a mesma até que você ative esse código.
            
            \n\n';

            $mail->send();

            $classeNone = 'displayBlkGreen';
            $_SESSION['msg'] = "Foi enviado e-mail com instruções para recuperar a senha.
            Acesse a sua caixa de e-mail para recuperar a senha!";

            

        } catch (Exception $e) {
            $classeNone = 'displayBlkRed';
            $_SESSION['msg'] = "Erro: E-mail não enviado. Mailer Error: {$mail->ErrorInfo}";
        }

    } else {
        $classeNone = 'displayBlkRed';
        $_SESSION['msg'] = 'E-mail não existente no sistema';
    }

    
}
if(!empty($erroAtualizaSenhaCrypt)) {
    if(password_verify($erroAtualizaSenha, $erroAtualizaSenhaCrypt)) {
        $classeNone = 'displayBlkRed';
        $_SESSION['msg'] = 'Erro ao acessar página, solicite um novo link';
    }
}

$mensagem = $_SESSION['msg'];



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar senha</title>
    <!--BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--ARQUIVO CSS-->
    <link rel="stylesheet" href="assets/style/base.css"/>
    <link rel="stylesheet" href="assets/style/recuperarSenha.css"/>
    <!--FONTE MARCELLUS-SC-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Marcellus+SC&display=swap" rel="stylesheet">
</head>
<body>
    <header class="topBar background-primary-color">
        <div class="container">
            <img width="50px" src="assets/img/logoSaas.svg">

        </div>
    </header>
    <main class="container">
        <div class="row">
            <div class="col-md-6" id="bannerLogin">
                <section class="first-banner-saas">
                    <img width="60%" src="assets/img/logoSaas.svg">
                    <p class="color-tertiary" >Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas saepe voluptate maxime quae numquam perspiciatis dolore, harum maiores in, fuga voluptatem est magnam hic? Illum impedit libero obcaecati repellat praesentium.</p>
                </section>
            </div>
            <div class="col-12 col-md-6">
                <section class="border-radius-button formBase" id="formRecuperarSenha">
                    <form method="POST" action="recuperarSenha.php"> <!--ENVIA OS DADOS PARA VERIFICAR SE ESSE USUARIO EXISTE E SE ELE TEM ACESSO AO RELATORIO-->
                        <p class="<?=$classeNone?> text-center"><?=$mensagem?></p>

                        <input class="inputAlt maxWidth" type="text" name="email_usu" placeholder="Digite o email para recuperação de senha" required>

                        <br><br>

                        <input class="border-radius-button submit-padding-top-bottom maxWidth background-primary-color border-none color-white" type="submit" value="Recuperar senha">
                    </form>
                    <br>
                    <a class="noDecorations color-primary text-center link-color-primary" href="cadastrar.php">Cadastrar-se</a>

                    <hr>

                    <a class="noDecorations color-primary text-center link-color-primary" href="login.php">Fazer login</a>
                </section>
            </div>
        </div>
    </main>
    
</body>
</html>