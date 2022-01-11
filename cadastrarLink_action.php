<?php
session_start();

if(!$_SESSION['logged'] && !$_SESSION['admLogged']) {
    header('Location:index.php');
    exit;
}

require 'config.php';
require 'dao/RelatorioUsuariosDaoMysql.php';

$RelatorioUsuariosDao = new RelatorioUsuariosDaoMysql($pdo);


$link_rel = filter_input(INPUT_POST, 'link_rel');
$name_link_rel = filter_input(INPUT_POST, 'name_link_rel');
$data_rel = date('Y/m/d H:i:s');

if(!empty($link_rel)) {
    if(!$RelatorioUsuariosDao->verifyRowByLink($link_rel)) {
        $relatorioUsu = new RelatorioUsuarios;
        $relatorioUsu->setLinkRel($link_rel);
        $relatorioUsu->setNameLinkRel($name_link_rel);
        $relatorioUsu->setDataRel($data_rel);
        $RelatorioUsuariosDao->add($relatorioUsu);

        header('Location:registroUsuarios.php');
        exit; 
    } else {
        header('Location:registroUsuarios.php');
        exit; 
    }
    
}

