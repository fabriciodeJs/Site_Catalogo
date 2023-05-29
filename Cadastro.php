<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="assets/img/logo-comemorativa-terwal.webp" type="image/x-icon">
  <link rel="stylesheet" href="assets/css/cadastro.css">
  <title>Cadastro de Produto</title>
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
      <h1>Cadastro de Produtos</h1>
      <form enctype="multipart/form-data" action="assets/PHP/envioTeste.php" method="post">
        <div>
          <label class="labels" for="codigoProduto">Código Do Produto: </label>
          <input class="inputs" type="text" name="codigoProduto" id="codigoProduto" required>
        </div>
        <div>
          <label class="labels" for="nomeProduto">Nome Do Produto: </label>
          <input class="inputs" type="text" name="nomeProduto" id="nomeProduto" required>
        </div>
        <div>
          <label class="labels" for="descricaoProduto">Descrição Do Produto: </label>
          <input class="inputs" type="text" name="descricaoProduto" id="descricaoProduto" required>
        </div>

        <div>
          <label class="labels" for="valorProduto">Valor Do Produto: </label>
          <input class="inputs" type="text" name="valorProduto" id="valorProduto" required>
        </div>

        <div>
          <label class="labels" for="imagemProduto">Imagem Do Produto: </label>
          <input class="inputs" type="file" multiple="mutiple" name="imagemProduto[]" id="imagemProduto" required>
        </div>
        <div>
          <label class="labels" for="videoProduto">Video Do Produto: </label>
          <input class="inputs" type="file" name="videoProduto" accept="video/mp4, video/mov, video/mkv" id="videoProduto" required>
        </div>
        <input id="botaoSubmit" type="submit" value="Cadastrar">
      </form>
    </section>
  </main>

  <script src="assets/js/form.js"></script>
</body>

</html>