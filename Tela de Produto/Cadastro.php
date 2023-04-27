<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/cadastro.css">
    <title>Cadastro de Produto</title>
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
        <section>
            <h1>Cadastro de Produtos</h1>
            <form action="assets/PHP/envio.php" method="post">
                <div>
                    <label class="labels" for="nomeProduto">Nome Do Produto: </label>
                    <input class="inputs" type="text" name="nomeProduto" id="nomeProduto">
                </div>
                <div>
                    <label class="labels" for="codigoProduto">Código Do Produto: </label>
                    <input class="inputs" type="text" name="codigoProduto" id="codigoProduto">
                </div>

                <div>
                    <label class="labels" for="descricaoProduto">Descrição Do Produto: </label>
                    <input class="inputs" type="text" name="descricaoProduto" id="descricaoProduto">
                </div>

                <div>
                    <label class="labels" for="valorProduto">Valor Do Produto: </label>
                    <input class="inputs" type="text" name="valorProduto" id="valorProduto">
                </div>

                <div>
                    <label class="labels" for="imagemProduto">Imagem Do Produto: </label>
                    <input class="inputs" type="file" name="imagemProduto" id="imagemProduto">
                </div>
                <input id="botaoSubmit" type="submit" value="Cadastrar">
            </form>
        </section>
    </main>

    <script src="assets/js/form.js"></script>
</body>
</html>