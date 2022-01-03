<?php

session_start();

if(!$_SESSION['logged'] && !$_SESSION['admLogged']) {
    header('Location:index.php');
    exit;
}

require 'config.php';
require 'dao/RelatorioUsuariosDaoMysql.php';

$RelatorioUsuariosDao = new RelatorioUsuariosDaoMysql($pdo);

$id_rel = filter_input(INPUT_GET, 'id');

$RelatorioUsuariosDao->delete($id_rel);

header('Location:registroUsuarios.php');
exit;
?>