<?php

require 'config.php';
require 'dao/RelatorioUsuariosDaoMysql.php';

$RelatorioUsuariosDao = new RelatorioUsuariosDaoMysql($pdo);

$id_rel = filter_input(INPUT_GET, 'id');

$RelatorioUsuariosDao->delete($id_rel);

header('Location:registroUsuarios.php');
exit;
?>