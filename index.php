
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form method="POST" action="verificaUsuario.php">
        <label>E-mail</label>
        <input type="text" name="email_cli" placeholder="Digite o email">

        <br><br>

        <label>Senha</label>
        <input type="password" name="senha_cli" placeholder="Digite sua senha">

        <input type="submit" value="Acessar">
    </form>
    <p>Não tem conta? Clique <a href="cadastrar.php">aqui</a> e se cadastre agora.</p>
</body>
</html>