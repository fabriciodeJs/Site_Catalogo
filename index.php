<?php
include('assets/PHP/Conexao.php');

    $pagina = 1;
    //PEGA O NUMERO DA PAGINA VIA URL
    if (isset($_GET['pagina']))
        $pagina = filter_input(INPUT_GET, "pagina", FILTER_VALIDATE_INT);

    if (!$pagina)
        $pagina = 1;

    $limitePorPagina = 4;

    $pagina_1 = ($pagina * $limitePorPagina) - $limitePorPagina;
    //TOTAL DE PRODUTOS CADASTRADOS
    $totalRegistro = $mysqli->query("SELECT COUNT(CODIGO) total FROM PRODUTO")->fetch_array()['total'];

    $totalPaginas = ceil($totalRegistro / $limitePorPagina);
    

    if (!empty($_GET['pesquisar'])) {
        $pesquisa = $_GET['pesquisar'];
        //PESQUISA NO BANCO DE DADOS
        $query = "SELECT CODIGO, NOME, DESCRICAO, IMAGEM FROM PRODUTO 
        WHERE CODIGO LIKE '%$pesquisa%' OR NOME LIKE '%$pesquisa%' OR DESCRICAO LIKE '%$pesquisa%'";
    }else{
        //LIMITA QUANTIDADE DE PRODUTOS POR PAGINA
        $query = "SELECT CODIGO, NOME, DESCRICAO, IMAGEM FROM PRODUTO LIMIT $pagina_1, $limitePorPagina";
    } 

    $consulta = $mysqli->query($query) or die($mysqli->error);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/logo-comemorativa-terwal.webp" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css" media="all">
    <title>Catalogo</title>
</head>

<body>
    <header id="container-cabecalho">
        <div id="logo">
            <img src="assets/img/logo-comemorativa-terwal.webp" alt="Logo Terwal">
        </div>
        <div id="botao">
            <a href="Cadastro.php">Cadastrar</a>
        </div>
    </header>
    <main>
        <section id="container-pesquisar">
            <input type="search" name="pesquisar" id="pesquisar">
            <button onclick="pesquisarProduto()">pesquisar</button>
        </section>
        <section>
            <?php while ($dado = $consulta->fetch_array()) { ?>
                <div onclick="gerarPagina('<?php echo $dado['CODIGO'] ?>')" class="container-item">
                    <div class="card-item">
                        <div>
                            <img id="imagens" src="<?php echo $dado['IMAGEM'] ?>" alt="<?php echo $dado['NOME'] ?>">
                        </div>
                        <h3><?php echo $dado['NOME'] ?></h3>
                        <p><?php echo $dado['DESCRICAO'] ?></p>
                    </div>
                </div>
            <?php } ?>
        </section>
        <!--VERIFICA SE FOI FEITA A PESQUISA E RETIRA A PAGINAÇÃO-->
        <?php if(empty($_GET['pesquisar'])): ?>
            <div id="paginacao">
                <a href="?pagina=1">Primeira</a>

                <?php if ($pagina > 1) : ?>
                    <a href="?pagina=<?php echo $pagina - 1 ?>"><<</a>
                <?php endif; ?>

                <p><?php echo $pagina; ?></p>

                <?php if ($pagina < $totalPaginas) : ?>
                    <a href="?pagina=<?php echo $pagina + 1 ?>">>></a>
                <?php endif; ?>

                <a href="?pagina=<?php echo $totalPaginas ?>">Ultima</a>
            </div>
        <?php endif; ?>
    </main>
    <script src="assets/js/script.js"></script>
</body>

</html>