<?php
require 'config.php';
require 'dao/UsuarioClienteDaoMysql.php';
require 'dao/UsuarioAdministradorDaoMysql.php';
require 'dao/RelatorioUsuariosDaoMysql.php';

$UsuarioClienteDao = new UsuarioClienteDaoMysql($pdo);
$UsuarioAdministradorDao = new UsuarioAdministradorDaoMysql($pdo);
$RelatorioUsuariosDao = new RelatorioUsuariosDaoMysql($pdo);

$usuarioCli = $UsuarioClienteDao->findAll();
$relatorioUsuario = $RelatorioUsuariosDao->findAll();

$link_rel = filter_input(INPUT_POST, 'link_rel');
$data_rel = date('Y/m/d H:i:s');

if(!empty($link_rel)) {
    $relatorioUsu = new RelatorioUsuarios;
    $relatorioUsu->setLinkRel($link_rel);
    $relatorioUsu->setDataRel($data_rel);
    $RelatorioUsuariosDao->add($relatorioUsu);

    header('Location:registroUsuarios.php');
    exit;
}

