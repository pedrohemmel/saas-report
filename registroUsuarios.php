<?php

session_start();

require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';
require 'dao/UsuarioAdministradorDaoMysql.php';
require 'dao/RelatorioUsuariosDaoMysql.php';

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);
$UsuarioAdministradorDao = new UsuarioAdministradorDaoMysql($pdo);
$RelatorioUsuariosDao = new RelatorioUsuariosDaoMysql($pdo);

$usuarioCli = $UsuarioClienteDao->findAll();
$relatorioUsuario = $RelatorioUsuariosDao->findAll();

if(!$_SESSION['logged']) {
    header('Location:index.php');
    exit;
} 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar registros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <a href="login.php?msg=<?=$_SESSION['msg'];?>">Logout</a>

    <table border="1" width="100%">
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Empresa</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Data d/registro</th>
            <th>Situação</th>
            <th>Data limite</th>
            <th>ações</th>
        </tr>
        <?php
            foreach($usuarioCli as $getUsuario):
        ?>
        <tr>
            <td><?=$getUsuario->getIdCli();?></td>
            <td><?=$getUsuario->getNomeCli();?></td>
            <td><?=$getUsuario->getEmpresaCli();?></td>
            <td><?=$getUsuario->getEmailCli();?></td>
            <td><?=$getUsuario->getTelefoneCli();?></td>
            <td><?=$getUsuario->getDataHoraCadastro();?></td>
            <td><?=$getUsuario->getSituacaoCli();?></td>
            <td><?=$getUsuario->getDataLimiteAcesso();?></td>
            <td>
                <a href="editarCli.php?id=<?=$getUsuario->getIdCli();?>">Editar</a>
                <a href="apagarCli.php?id=<?=$getUsuario->getIdCli();?>">Apagar</a>
            </td>
        </tr>
        <?php
            endforeach;
        ?>
    </table>
    <form method="POST" action="cadastrarLink_action.php">
        <label>Adicione o link do iframe</label>
        <input type="text" name="link_rel" placeholder="Adicione um link" required>

        <br><br>

        <input type="submit" value="Adicionar">
    </form>
    <table border="1" width="100%">
        <tr>
            <th>Id</th>
            <th>Link</th>
            <th>Data d/registro</th>
            <th>ações</th>
        </tr>
        <?php
            foreach($relatorioUsuario as $getRelatorio):
        ?>
        <tr>
            <td><?=$getRelatorio->getIdRel();?></td>
            <td><?=$getRelatorio->getLinkRel();?></td>
            <td><?=$getRelatorio->getDataRel();?></td>
            <td>
                <a href="apagarLink.php?id=<?=$getRelatorio->getIdRel();?>">Apagar</a>
            </td>
        </tr>
        <?php
            endforeach;
        ?>
    </table>
</body>
</html>

<?php
exit;
?>