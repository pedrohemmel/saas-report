
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form method="POST" action="verificaUsuario.php"> <!--ENVIA OS DADOS PARA VERIFICAR SE ESSE USUARIO EXISTE E SE ELE TEM ACESSO AO RELATORIO-->
        <label>E-mail</label>
        <input type="text" name="email_usu" placeholder="Digite o email" required>

        <br><br>

        <label>Senha</label>
        <input type="password" name="senha_usu" placeholder="Digite sua senha" required>

        <input type="submit" value="Acessar">
    </form>
    <p>Não tem conta? Clique <a href="cadastrar.php">aqui</a> e se cadastre agora.</p>
</body>
</html>