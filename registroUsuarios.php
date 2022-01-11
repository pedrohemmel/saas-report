<?php

session_start();

$_SESSION['admLogged'] = true;

require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';
require 'dao/UsuarioAdministradorDaoMysql.php';
require 'dao/RelatorioUsuariosDaoMysql.php';

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);
$UsuarioAdministradorDao = new UsuarioAdministradorDaoMysql($pdo);
$RelatorioUsuariosDao = new RelatorioUsuariosDaoMysql($pdo);

$msg = filter_input(INPUT_GET, 'msg');
$id = filter_input(INPUT_GET, 'id');

$usuarioCli = $UsuarioClienteDao->findAll();
$relatorioUsuario = $RelatorioUsuariosDao->findAll();



if(!$_SESSION['logged']) {
    header('Location:index.php');
    exit;
} 

//VER MAIS
if(!empty($_SESSION['verMais'])) {
    if(!($_SESSION['verMais'] == 'verMaisBlock'))  {
        $_SESSION['verMais'] == 'verMaisNone';
    }
} else {
    $_SESSION['verMais'] == 'verMaisNone';
}


if(!empty($msg)) {
    if(password_verify($_SESSION['msgAlt'], $msg)) {
        print_r($_SESSION['msgAlt']);
    }
}

if(!empty($id)) {
    if($UsuarioClienteDao->verifyRowById($id)) {
       $usuarioCliAlt = $UsuarioClienteDao->findById($id);  

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
        
            header('Location:registroUsuarios.php');
            exit;
        } else if(strtotime($dataLimiteAcesso) >= strtotime($dataAtual) && $status === 'inativo') {
            $acesso = 'ativo';
            $usuarioAlt = new UsuarioCliente;
            $usuarioAlt->setIdCli($id_cli);
            $usuarioAlt->setSituacaoCli($acesso);
            
            $UsuarioClienteDao->updateSituacao($usuarioAlt);
        
            header('Location:registroUsuarios.php');
            exit;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar registros</title>
   <!--BOOTSTRAP-->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!--ARQUIVO CSS-->
    <link rel="stylesheet" href="assets/style/base.css"/>
    <link rel="stylesheet" href="assets/style/registroUsuarios.css"/>
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

    <main class="container">


        <!--Formato mobile/desktop-->
        <div style="max-height: 400px; overflow: auto;margin-top:1em;">
            <table border="1" width="100%">
                <tr>
                    <th>Email</th>
                    <th>Situação</th>
                    <th>...</th>
                </tr>

                <?php
                    foreach($usuarioCli as $getUsuario):
                ?>
                    <tr>
                        <td><?=$getUsuario->getEmailCli();?></td>
                        <td><?=$getUsuario->getSituacaoCli();?></td>
                        <td class="background-tertiary-color">
                            <a class="color-white" href="verMais_action.php?id=<?=$getUsuario->getIdCli();?>">Ver mais</a>
                        </td>
                    </tr> 
                <?php
                    endforeach;
                ?>
            </table> 
        </div>  

        
            
        <section id="formRegistrarLink">
            <form class="maxWidth" method="POST" action="cadastrarLink_action.php" >
                <input class="inputLink inputAlt maxWidth" type="text" name="link_rel" placeholder="Adicione um link para o iframe" required>

                <br><br>

                <input class="inputLink inputAlt maxWidth" type="text" name="name_link_rel" placeholder="Digite o nome do link" required>

                <br><br>

                <input class="border-radius-button submit-padding-top-bottom maxWidth background-primary-color border-none color-white" type="submit" value="Adicionar">
            </form>
        </section>

        <!--Formato mobile/desktop-->
        <div style="max-height: 400px; overflow: auto; margin-bottom: 1em;">
            <table border="1" width="100%">
                <tr>
                    <th>Id</th>
                    <th>Nome do link</th>
                    <th>ações</th>
                </tr>

                <?php
                    foreach($relatorioUsuario as $getRelatorio):
                ?>
                <tr>
                    <td><?=$getRelatorio->getIdRel();?></td>
                    <td><?=$getRelatorio->getNameLinkRel();?></td>
                    <td class="background-tertiary-color">
                        <a class="color-white" href="apagarLink.php?id=<?=$getRelatorio->getIdRel();?>">Apagar</a>
                    </td>
                </tr>
                <?php
                    endforeach;
                ?>
            </table>
        </div>
            

        
        
    </main>

    <section class="<?=$_SESSION['vermais']?>">

    </section>
</body>
</html>

<?php
exit;
?>
