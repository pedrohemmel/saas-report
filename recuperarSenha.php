
<?php
require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

$email_usu = filter_input(INPUT_POST, 'email_usu');
$erroAtualizaSenhaCrypt = filter_input(INPUT_GET, 'erro');

$erroAtualizaSenha = 'Erro ao acessar página, solicite um novo link';

if(!empty($email_usu)) {
    
    $UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);

    if($UsuarioClienteDao->verifyRowByEmail($email_usu)) {

        $usuario = $UsuarioClienteDao->findByEmail($email_usu);

        foreach($usuario as $getUsuario) {
            $id = $getUsuario->getIdCli();
        }  

        $chave_recuperar_senha = password_hash($id, PASSWORD_DEFAULT);

        $usuario_recuperar_senha = new UsuarioCliente;
        $usuario_recuperar_senha->setIdCli($id);
        $usuario_recuperar_senha->setRecuperaSenhaCli($chave_recuperar_senha);

        $UsuarioClienteDao->updateRecuperarSenha($usuario_recuperar_senha);
        

        header('Location:http://localhost/saas-report/atualizarSenha.php?chave='.$chave_recuperar_senha);
        exit;
    } else {
        echo '<p style="color:#f00">E-mail não existente no sistema</p>';
    }

    
}

if(password_verify($erroAtualizaSenha, $erroAtualizaSenhaCrypt)) {
    echo '<p style="color:#f00">Erro ao acessar página, solicite um novo link</p>';
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <a href="login.php">Login</a>
    <form method="POST" action=""> <!--ENVIA OS DADOS PARA VERIFICAR SE ESSE USUARIO EXISTE E SE ELE TEM ACESSO AO RELATORIO-->
        <label>E-mail</label>
        <input type="text" name="email_usu" placeholder="Digite o email" required>

        <br><br>

        <input type="submit" value="Recuperar">
    </form>

    <p>Não tem conta? Clique <a href="cadastrar.php">aqui</a> e se cadastre agora.</p>
</body>
</html>