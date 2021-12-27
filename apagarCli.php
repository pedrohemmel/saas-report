<?php

require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);

$id_cli = filter_input(INPUT_GET, 'id');

$UsuarioClienteDao->delete($id_cli);

header('Location:registroUsuarios.php');
exit;
?>