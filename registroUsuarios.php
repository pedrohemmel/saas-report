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
$msgVlt = filter_input(INPUT_GET, 'msgVlt');
$msgEditVlt = filter_input(INPUT_GET, 'msgEditVlt');
$msgEdit = filter_input(INPUT_GET, 'msgEdit');
$msgErroEdit = filter_input(INPUT_GET, 'msgErroEdit');

$usuarioCli = $UsuarioClienteDao->findAll();
$relatorioUsuario = $RelatorioUsuariosDao->findAll();

//condições de requisições GET

$classeNone = 'displayNone';

if(!$_SESSION['logged']) {
    header('Location:index.php');
    exit;
} 

if(!empty($msgVlt)) {
    if(password_verify($_SESSION['msgVlt'], $msgVlt)) {
        $_SESSION['verMais'] = 'null';
        $bodyVerMais = 'null';
    }
}

if(!empty($msgErroEdit)) {
    if(password_verify($_SESSION['erroEdit'], $msgErroEdit)) {
        $classeNone = 'displayBlkRed';
        $_SESSION['msg'] = $_SESSION['erroEdit'];
    }
} else if(!empty($msgEditVlt)) {
    if(password_verify($_SESSION['msgEdit'], $msgEditVlt)) {
        $_SESSION['verMais'] = 'verMaisBlock';
        $_SESSION['editar'] = 'null';
        $bodyVerMais = 'null';
    }
} else if(!empty($msgEdit)) {
    if(password_verify($_SESSION['msgEdit'], $msgEdit)) {
        $classeNone = 'displayBlkGreen';
        $_SESSION['msg'] = $_SESSION['msgEdit'];
        $_SESSION['editar'] = 'null';
        $_SESSION['verMais'] = 'verMaisBlock';
    }
}

$mensagem = $_SESSION['msg'];


//VER MAIS

$_SESSION['msgVlt'] = 'voltarVerMais';
$_SESSION['msgCrypt'] = password_hash($_SESSION['msgVlt'], PASSWORD_DEFAULT);




if(!empty($_SESSION['verMais'])) {
    if(!($_SESSION['verMais'] == 'verMaisBlock'))  {
        $_SESSION['verMais'] = 'verMaisNone';
        $bodyVerMais = 'null';
        
    } else {
        $bodyVerMais = 'bodyVerMais';
    }
} else {
    $_SESSION['verMais'] = 'verMaisNone';
    $bodyVerMais = 'null';
}

if(!empty($_SESSION['id'])) {
    if($UsuarioClienteDao->verifyRowById($_SESSION['id'])) {
        $usuarioCliId = $UsuarioClienteDao->findById($_SESSION['id']);
        foreach($usuarioCliId as $getUsuario) {
            $id_cli = $getUsuario->getIdCli();
            $nome_cli = $getUsuario->getNomeCli();
            $empresa_cli = $getUsuario->getEmpresaCli();
            $email_cli = $getUsuario->getEmailCli();
            $telefone_cli = $getUsuario->getTelefoneCli();
            $dataHoraCadastro = $getUsuario->getDataHoraCadastro();
            $situacao_cli = $getUsuario->getSituacaoCli();
            $verificacao_cli = $getUsuario->getVerificacaoCli();
            $dataLimiteAcesso = $getUsuario->getDataLimiteAcesso();
        }
    }
} else {
    $id_cli = 'null';
    $nome_cli = 'null';
    $empresa_cli = 'null';
    $email_cli = 'null';
    $telefone_cli ='null';
    $dataHoraCadastro = 'null';
    $situacao_cli = 'null';
    $verificacao_cli = 'null';
    $dataLimiteAcesso = 'null';
}

$verMais = $_SESSION['verMais'];

//EDITAR


$_SESSION['msgEdit'] = 'voltarEdit';
$_SESSION['msgEditCrypt'] = password_hash($_SESSION['msgEdit'], PASSWORD_DEFAULT);

if(!empty($_SESSION['editar'])) {
    if(!($_SESSION['editar'] == 'editarBlock'))  {
        $_SESSION['editar'] = 'editarNone';
        
        
    } else {
        $bodyVerMais = 'bodyVerMais';
    }
} else {
    $_SESSION['editar'] = 'editarNone';
    
}

$editar = $_SESSION['editar'];


//Atualizar

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
<body class="<?=$bodyVerMais?>">
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
                            <a class="text-hover-white color-white" href="verMais_action.php?id=<?=$getUsuario->getIdCli();?>">Ver mais</a>
                        </td>
                    </tr> 
                <?php
                    endforeach;
                ?>
            </table> 
        </div>  

        
            
        <section id="formRegistrarLink">
            <form class="maxWidth" method="POST" action="cadastrarLink_action.php" >

                <h6>Adicione um link para o usuário visualizar <i class="bi bi-eye" style="margin-left: 5px;"></i></h5>
                
                <br>

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
                        <a class="text-hover-white color-white" href="apagarLink.php?id=<?=$getRelatorio->getIdRel();?>">Apagar</a>
                    </td>
                </tr>
                <?php
                    endforeach;
                ?>
            </table>
        </div>
            

        
        
    </main>

    <section class="<?=$verMais;?>">
        <div class="container" id="verMaisForm">
            <div class="formBase" >
                <a class="text-hover-white noDecorations border-radius-button background-primary-color border-none color-white buttonVerMais" href="registroUsuarios.php?msgVlt=<?=$_SESSION['msgCrypt'];?>">Voltar <i class="color-white bi bi-backspace-reverse" style="margin-left: 5px;"></i></a>
                <br class="<?=$classeNone?>">
                <p class="<?=$classeNone?> text-editVermais"><?=$mensagem?></p>
                <br>
                <article class="row">
                    <p class="col-12 col-md-6 labelVerMais">Id</p>
                    <p class="col-12 col-md-6 marginVerMais"><?=$id_cli;?></p>
                    <p class="col-12 col-md-6 labelVerMais">Nome</p>
                    <p class="col-12 col-md-6 marginVerMais"><?=$nome_cli;?></p>
                    <p class="col-12 col-md-6 labelVerMais">Empresa</p>
                    <p class="col-12 col-md-6 marginVerMais"><?=$empresa_cli;?></p>
                    <p class="col-12 col-md-6 labelVerMais">Data d/Registro</p>
                    <p class="col-12 col-md-6 marginVerMais"><?=$dataHoraCadastro;?></p>
                    <p class="col-12 col-md-6 labelVerMais">Data limite de acesso</p>
                    <p class="col-12 col-md-6 marginVerMais"><?=$dataLimiteAcesso;?></p>
                    <br><br><br><br>
                    <p class="col-12 col-md-6 labelVerMais">Situação</p>
                    <p class="col-12 col-md-6 marginVerMais"><?=$situacao_cli;?></p>
                    <p class="col-12 col-md-6 labelVerMais">E-mail verificado</p>
                    <p class="col-12 col-md-6 marginVerMais"><?=$verificacao_cli;?></p>
                    <br><br><br><br>
                    <p class="col-12 col-md-6 labelVerMais">E-mail</p>
                    <p class="col-12 col-md-6 marginVerMais"><?=$email_cli;?></p>
                    <p class="col-12 col-md-6 labelVerMais">Telefone</p>
                    <p class="col-12 col-md-6 marginVerMais"><?=$telefone_cli?></p>
                    <br><br><br><br>
                    <div class="col-12 row" id="editUpDel">
                        <a class="text-hover-white col-12 col-md-4 noDecorations border-radius-button background-primary-color border-none color-white buttonVerMais" href="editarCli.php?id=<?=$id_cli;?>">Editar <i class="color-white bi bi-pencil" style="margin-left: 5px;"></i></a>
                        <a class="text-hover-white col-12 col-md-4 noDecorations border-radius-button background-primary-color border-none color-white buttonVerMais" href="registroUsuarios.php?id=<?=$id_cli;?>">Atualizar <i class="color-white bi bi-arrow-counterclockwise" style="margin-left: 5px;"></i></a>
                        <a class="text-hover-white col-12 col-md-4 noDecorations border-radius-button background-primary-color border-none color-white buttonVerMais" href="apagarCli.php?id=<?=$id_cli;?>">Apagar <i class="color-white bi bi-trash" style="margin-left: 5px;"></i></a>
                    </div>
                    
                </article>
            </div>
        </div>
    </section>
    <section class="<?=$editar;?>">
        <div class="container" id="editarForm">
            <div class="formBase" >
                <a class="text-hover-white noDecorations border-radius-button background-primary-color border-none color-white buttonVerMais" href="registroUsuarios.php?msgEditVlt=<?=$_SESSION['msgEditCrypt'];?>">Voltar <i class="color-white bi bi-backspace-reverse" style="margin-left: 5px;"></i></a>
                <br class="<?=$classeNone?>">
                <p class="<?=$classeNone?> text-editVermais"><?=$mensagem?></p>
                <br>
                <form method="POST" action="editarCli_action.php">
                    <label>Nome</label>
                    <input class="inputLink inputAlt maxWidth" type="text" name="nome_cli_alt" value="<?=$_SESSION['nome_cli']?>" required>
                    <br><br>
                    <label>Empresa</label>
                    <input class="inputLink inputAlt maxWidth" type="text" name="empresa_cli_alt" value="<?=$_SESSION['empresa_cli']?>" required>
                    <br><br>
                    <label>E-mail</label>
                    <input class="inputLink inputAlt maxWidth" type="text" name="email_cli_alt" value="<?=$_SESSION['email_cli']?>" required>
                    <br><br>
                    <label>Telefone</label>
                    <input class="inputLink inputAlt maxWidth" type="text" name="telefone_cli_alt" value="<?=$_SESSION['telefone_cli']?>" minlength="11" maxlength="11" required>
                    <br><br>
                    <label>Tempo de acesso</label>
                    <p style="color:gray">Digite a quantidade de dias de acesso que deseja liberar para esse usuário</p>
                    <input type="number" name="data_limite_acesso_alt" min="0" max="365" >
                    <br><br>
                    <input type="checkbox" name="retirarAcesso">
                    <label>Desejo tirar o acesso desse usuário ao meu conteúdo</label>
                    <br><br>
                    <input class="border-radius-button submit-padding-top-bottom maxWidth background-primary-color border-none color-white" type="submit" value="Alterar">
                </form>
            </div>
        </div>
    </section>
</body>
</html>

<?php
exit;
?>
