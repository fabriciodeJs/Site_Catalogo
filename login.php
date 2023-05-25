<?php
if (!empty($_POST['login']) and !empty($_POST['senha'])) {
    echo header("location: Cadastro.php");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Login</title>
</head>

<body>
<header id="container-cabecalho">
        <div id="logo">
            <img src="assets/img/logo-comemorativa-terwal.webp" alt="Logo Terwal">
        </div>
        <div id="botao">
            <a href="index.php">Home</a>
        </div>
    </header>
    <main>
        <section>
            <div id="container">
                <div id="logo-login">
                    <!--Imagem-->
                </div>
                <form action="login.php" method="post">
                    <div id="input">
                        <input placeholder="Login" class="login" type="text" name="login" id="login" >
                        <input placeholder="Senha" class="login" type="password" name="senha" id="senha" >
                        <input id="botao-submit" type="submit" value="Entrar">
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>

</html>