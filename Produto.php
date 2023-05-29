<?php
include_once('assets/PHP/Conexao.php');

if (isset($_GET['codigo'])) {
  $codigo = $_GET['codigo'];

  $query = "SELECT PRODUTO.CODIGO, PRODUTO.NOME, PRODUTO.DESCRICAO, IMAGENS.IMAGEM_1, IMAGENS.IMAGEM_2, IMAGENS.IMAGEM_3, IMAGENS.IMAGEM_4,
    IMAGENS.IMAGEM_5, IMAGENS.IMAGEM_6, IMAGENS.VIDEO FROM PRODUTO JOIN IMAGENS
    ON PRODUTO.CODIGO = IMAGENS.CODIGO_PRODUTO WHERE IMAGENS.CODIGO_PRODUTO = '$codigo' ";

  $consulta = $conn->query($query) or die($conn->$error);

  $dado = $consulta->fetch(PDO::FETCH_BOTH);
} else {
  echo "ERROR";
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="assets/img/logo-comemorativa-terwal.webp" type="image/x-icon">
  <link rel="stylesheet" href="assets/css/produto.css">
  <title><?php echo $dado['NOME'] ?></title>
</head>

<body>
  <header id="container-cabecalho">
    <div id="botao-home">
      <a href="index.php">Home</a>
    </div>
    <div id="logo">
      <img src="assets/img/logo-comemorativa-terwal.webp" alt="Logo Terwal">
    </div>
    <div id="botao-login">
      <a href="login.php">Login</a>
    </div>
  </header>
  <main>
    <section>
      <div onclick="navegar(-1)" id="seta-left" class="navegacao-img">
        <i class="fa-solid fa-arrow-left"></i>
      </div>
      <div id="container-img">
        <img id="img" src="" alt="<?php echo $dado['NOME'] ?>" style="display: flex;">
        <?php if (!empty($dado['VIDEO'])) { ?>
          <video id="video" style="display: none;" src="<?php echo $dado['VIDEO'] ?>" controls></video>
          <div id="div-botao-play">
            <i id="botao-play" style="display: flex;" onclick="mostraVideo()" class="fa-solid fa-circle-play"></i>
          </div>
          <div id="div-botao-img">
            <i style="display: none;" id="botao-img" onclick="mostraVideo()" class="fa-solid fa-image"></i>
          </div>
        <?php } ?>
      </div>
      <div onclick="navegar(1)" id="seta-right" class="navegacao-img">
        <i id="right" class="fa-solid fa-arrow-right"></i>
      </div>
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
  <script src="https://kit.fontawesome.com/546ab0e97a.js" crossorigin="anonymous"></script>
  <script src="assets/js/produto.js"></script>
  <script>
    //CARROSSEL 
    var indice = 1;
    var totalImages = 0;
    var imagens = [
      <?php
      for ($i = 1; $i <= 6; $i++) {
        //COLOCANDO AS IMAGENS NO ARRAY
        $imagem = $dado["IMAGEM_" . $i];
        if (!empty($imagem)) {
          echo "'" . $imagem . "',";
        }
      }
      ?>
    ];
    // EXIBIR IMAGENS
    function exibirImagem() {
      const img = document.querySelector("#img");
      img.src = imagens[indice - 1];
      img.alt = "<?php echo $dado['NOME']; ?>";
    }
    //NAVEGAR ENTRE AS FOTOS
    function navegar(direcao) {
      indice += direcao;
      // VERIFICA SE CHEGOU AO LIMITE DE IMG
      if (indice < 1) {
        indice = totalImages;
      } else if (indice > totalImages) {
        indice = 1;
      }
      exibirImagem();
    }
    // MOSTRA AS IMG QUANDO A PAGINA CARREGA
    totalImages = imagens.length;
    exibirImagem();
  </script>
</body>

</html>