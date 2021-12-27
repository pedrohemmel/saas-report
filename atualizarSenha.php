<?php
require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);

//CASO O LINK PARA ACESSAR A SENHA ESTIVER ERRADO
$erroAtualizaSenha = 'Erro ao acessar página, solicite um novo link';
$erroAtualizaSenhaCrypt = password_hash($erroAtualizaSenha, PASSWORD_DEFAULT);

$chave = filter_input(INPUT_GET, 'chave');

if($UsuarioClienteDao->verifyRowByKey($chave)) {
    $usuarioPorChave = $UsuarioClienteDao->findByKeyPass($chave);

    foreach($usuarioPorChave as $getUsuario) {
        $nomeCli = $getUsuario->getNomeCli();
        $chaveCli = $getUsuario->getRecuperaSenhaCli();
    }
} else {
    header('Location:recuperarSenha.php?erro='.$erroAtualizaSenhaCrypt);
    exit;
}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <form method="POST" action="atualizaSenha_action.php">
        <label>Senha</label>
        <input type="text" name="senha_cli" placeholder="Digite sua nova senha" required>

        <br><br>

        <input type="submit" value="Atualizar">
    </form>
</body>
</html>