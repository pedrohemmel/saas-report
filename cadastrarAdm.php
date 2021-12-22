<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!--Criando um formulário com action para o cadastrar_action.php que vai confirmar os dados e subir pro banco de dados
como um registro-->
    <form method="POST" action="cadastrarAdm_action.php">
        <label>Nome de usuário</label>
            <input type="text" name="nome_adm" placeholder="Digite o nome de usuário" required>
        <br><br>

        <label>E-mail</label>
            <input type="email" name="email_adm" placeholder="Digite seu e-mail" required>
        <br><br>

        <label>Confirmar e-mail</label>
            <input type="email" name="confirm_email_adm" placeholder="Confirme seu e-mail" required>
        <br><br>

        <label>Telefone</label>
            <input type="tel" name="telefone_adm" placeholder="Digite seu telefone" required>
        <br><br>
        
        <label>Senha</label>
            <input type="password" name="senha_adm" placeholder="Digite sua senha" required>
        <br><br>
        <label>Confirmar senha</label>
            <input type="password" name="confirm_senha_adm" placeholder="Confirme sua senha" required>
        <br><br>
        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>