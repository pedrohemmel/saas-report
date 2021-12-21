<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form>
        <label>Usuário</label>
        <input type="text" name="usuario" placeholder="Digite o usuário">
        <?php

        


        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y H:i', strtotime('+7 days'));;
        
        echo $data;
        ?>
        <br><br>

        <label>Senha</label>
        <input type="password" name="senha" placeholder="Digite sua senha">

        <p>Não tem conta? Clique <a href="cadastrar.php">aqui</a> e se cadastre agora.</p>

        <input type="submit" value="Acessar">
    </form>
</body>
</html>