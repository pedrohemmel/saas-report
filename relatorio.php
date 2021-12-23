<?php
require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';
require 'dao/RelatorioUsuariosDaoMysql.php';

/*AQUI FOI PESQUISADO O NOME DO USUARIO PARA COLOCAR NA TELA*/
$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);
$RelatorioUsuariosDao = new RelatorioUsuariosDaoMysql($pdo);

$id_cli = filter_input(INPUT_GET, 'id');


$usuario = $UsuarioClienteDao->findById($id_cli);
$relatorioUsuario = $RelatorioUsuariosDao->findAll();

foreach($usuario as $getUsuario) {
    $nome = $getUsuario->getNomeCli();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Bem vindo, <?=$nome?></p>

    <?php
    foreach($relatorioUsuario as $getRelatorio):
    ?>
    <iframe width="80%;" height="700px" src="<?=$getRelatorio->getLinkRel();?>" title="Apple Developer Academy"></iframe>
    <?php
    endforeach;
    ?>
</body>
</html>