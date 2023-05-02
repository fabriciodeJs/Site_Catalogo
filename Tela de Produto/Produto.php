<?php
include('assets/PHP/Conexao.php');

$query = "SELECT CODIGO, NOME, DESCRICAO, IMAGEM FROM PRODUTO";

$consulta = $mysqli->query($query) or die($mysqli->error);

$dado = $consulta->fetch_array();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/produto.css">
    <title>Produto</title>
</head>

<body>
    <header id="container-cabecalho">
        <img src="assets/img/logo-comemorativa-terwal.webp" alt="Logo Terwal">
    </header>
    <main>
        <section>
            <img src="<?php echo $dado['IMAGEM'] ?>" alt="<?php echo $dado['NOME'] ?>">
        </section>
        <article>
            <div id="container">
                <div id="cabecalho-produto">
                    <p><strong>Código: <?php echo $dado['CODIGO'] ?></strong></p>
                    <h3><?php echo $dado['NOME'] ?></h3>
                </div>
                <hr>
                <div id="descricao-produto">
                    <p><strong>Descrição:</strong> <?php echo $dado['DESCRICAO'] ?></p>
                    <p><strong>Voltagem:</strong> aaaaaa</p>
                    <p><strong>Modelo:</strong> aaaaaa</p>
                    <p><strong>Cor:</strong> aaaaaa</p>
                    <p><strong>Marca:</strong> aaaaaa</p>
                    <p><strong>Modelo:</strong> aaaaaa</p>
                </div>
            </div>
        </article>
    </main>
</body>

</html>