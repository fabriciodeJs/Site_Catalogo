<?php
include('assets/PHP/Conexao.php');

$query = "SELECT NOME, DESCRICAO, IMAGEM FROM PRODUTO";

$consulta = $mysqli->query($query) or die($mysqli->error);



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css" media="all">
    <title>Produto</title>
</head>

<body>
    <header>
        <nav id="container-cabecalho">
            <div id="logo">Logo</div>
            <menu>
                <ul>
                    <li>Home</li>
                    <li>Categorias</li>
                    <li>Cadastro</li>
                    <li>Fale Conosco</li>
                </ul>
            </menu>
        </nav>
    </header>
    <main>
        <section id="saida">
            <?php

            while ($dado = $consulta->fetch_array()) {

                echo '<div class="container-item">';
                echo '<div class="card-item">';
                echo '<img src"' . $dado['IMAGEM'] .' ">';
                echo '<h3>' . $dado["NOME"] . '</h3>';
                echo '<p>' . $dado["DESCRICAO"] . '</p>';
                echo ' </div>';
                echo '</div>';
            } 
            ?>
        </section>
    </main>
    <script src="assets/js/script.js"></script>
</body>

</html>