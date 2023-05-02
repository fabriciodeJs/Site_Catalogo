<?php
include('assets/PHP/Conexao.php');

$query = "SELECT CODIGO, NOME, DESCRICAO, IMAGEM FROM PRODUTO";

$consulta = $mysqli->query($query) or die($mysqli->error);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css" media="all">
    <title>Catalogo</title>
</head>

<body>
    <header id="container-cabecalho">
        <img src="assets/img/logo-comemorativa-terwal.webp" alt="Logo Terwal">
    </header>
    <main>
        <section>
            <?php while ($dado = $consulta->fetch_array()) { ?>
                    <div onclick="gerarPagina('<?php echo $dado['CODIGO'] ?>')" class="container-item">
                        <div class="card-item">
                            <div>
                                <img id="imagens" src="<?php echo $dado['IMAGEM'] ?>" alt="<?php echo $dado['NOME'] ?>">
                            </div>
                            <h3><?php echo $dado['NOME'] ?></h3>
                            <p><?php echo $dado['DESCRICAO'] ?></p>
                            <p class="codigo" ><?php echo $dado['CODIGO'] ?></p>
                        </div>
                    </div>
            <?php } ?>
        </section>
    </main>
    <script src="assets/js/script.js"></script>
</body>

</html>