<?php

session_start();

if($_SESSION['loggedAdm'] === false) {
    header('Location:index.php');
    exit;
}

$id = filter_input(INPUT_GET, 'id');

$_SESSION['id'] = $id;

$_SESSION['verMais'] = 'verMaisBlock';

header('Location:registroUsuarios.php');

?>