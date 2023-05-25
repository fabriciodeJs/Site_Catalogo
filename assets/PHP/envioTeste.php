<?php
include_once('Conexao.php');

//VALIDADO INPUTS E ATRIBUINDO A VARIÁVEIS
if (isset($_POST['nomeProduto']) and $_POST['codigoProduto'] and $_POST['descricaoProduto'] and $_POST['valorProduto']) {
  $nomeProduto = $_POST['nomeProduto'];
  $codigoProduto = $_POST['codigoProduto'];
  $descricaoProduto = $_POST['descricaoProduto'];
  $valorProduto = $_POST['valorProduto'];

  //SALVANDO ARQUIVOS NO BANCO
  $query_produto = "INSERT INTO produto(CODIGO, NOME, DESCRICAO, VALOR) VALUES (?, ?, ?, ?)";
  $stmt_envioProduto = $conn->prepare($query_produto);
  $stmt_envioProduto->bindValue(1, $codigoProduto, PDO::PARAM_STR);
  $stmt_envioProduto->bindValue(2, $nomeProduto, PDO::PARAM_STR);
  $stmt_envioProduto->bindValue(3, $descricaoProduto, PDO::PARAM_STR);
  $stmt_envioProduto->bindValue(4, $valorProduto, PDO::PARAM_STR);
 if (!$stmt_envioProduto->execute()) die("<h1 style='color: red;>Falha ao fazer Upload!</h1>");

  //VALIDAÇÃO DE ENVIO DE IMAGEM
  if(!isset($_FILES['imagemProduto'])) die("<h1 style='color: red;>Falha Na Imagem!</h1>");

  //RECEBENDO IMAGEM DO FORMULARIO
  $imagemProduto = $_FILES['imagemProduto'];

  //PASTA QUE SERA SALVO A IMAGEM E GERANDO NOME UNICO
  $pastaServ = "../img/teste/$codigoProduto/";

  //CRIANDO PASTA
  mkdir($pastaServ, 0755);
  //VARIAVEL DE CONTROLE DE UPDATE
  $numeroColuna = 1;
  for ($i = 0; $i < count($imagemProduto['name']); $i++) {
    //GERANDO UM NOVO NOME PARA IMAGEM
    $nomeDaImg = $imagemProduto['name'][$i];
    $novoNomeImg = uniqid();
    $extensao = strtolower(pathinfo($nomeDaImg, PATHINFO_EXTENSION));

    //VALIDANDO TIPO DO ARQUIVO
    if ($extensao != 'jpg' and $extensao != 'png' and $extensao != 'webp')
    die("ADICIONE IMAGEM DO TIPO (PNG, JPG OU WEBP)");

    //SALVANDO IMAGEM NA PASTA E O CAMINHO NO BANCO DE DADOS
    $caminhoDaImgServidor = $pastaServ . $novoNomeImg . '.' . $extensao;
    $caminhoDaImgIndex = 'assets/img/teste/' . $codigoProduto . '/' . $novoNomeImg . '.' . $extensao;

    if (move_uploaded_file($imagemProduto["tmp_name"][$i], $caminhoDaImgServidor)) {
      // ENVIO DA IMAGEM PARA O BANCO DE DADOS
      
      //INSERINDO A PRIMEIRA IMAGEM NO BANCO
      if($numeroColuna === 1){
        $query_imagem = "INSERT INTO imagens(CODIGO_PRODUTO, IMAGEM_$numeroColuna) VALUES (?, ?)";
        $stmt_imagem = $conn->prepare($query_imagem);
        $stmt_imagem->bindValue(1, $codigoProduto, PDO::PARAM_STR);
        $stmt_imagem->bindValue(2, $caminhoDaImgIndex, PDO::PARAM_STR);
        if (!$stmt_imagem->execute()) echo "<h1 style='color: red;'>FALHA AO SALVAR IMAGEM NO BANCO</h1>";
      }else if($numeroColuna > 1){
        //ADICIONANDO AS OUTRAS IMAGEM NO BANCO
        $query_imagem = "UPDATE imagens SET IMAGEM_$numeroColuna = ? WHERE CODIGO_PRODUTO = ?";
        $stmt_imagem = $conn->prepare($query_imagem);
        $stmt_imagem->bindValue(1, $caminhoDaImgIndex, PDO::PARAM_STR);
        $stmt_imagem->bindValue(2, $codigoProduto, PDO::PARAM_STR);
        if (!$stmt_imagem->execute()) echo "<h1 style='color: red;'>FALHA AO SALVAR IMAGEM NO BANCO</h1>";

        // $query_produto = "INSERT INTO produto(CODIGO, NOME, DESCRICAO, VALOR) VALUES (?, ?, ?, ?)";
        // $stmt_envioProduto = $conn->prepare($query_produto);
        // $stmt_envioProduto->bindValue(1, $codigoProduto, PDO::PARAM_STR);
        // $stmt_envioProduto->bindValue(2, $nomeProduto, PDO::PARAM_STR);
        // $stmt_envioProduto->bindValue(3, $descricaoProduto, PDO::PARAM_STR);
        // $stmt_envioProduto->bindValue(4, $valorProduto, PDO::PARAM_STR);
      }
      $numeroColuna++;
    }
 }
}
echo '<h1>Prencha todos os Campos</h1>';
echo '<a href="../../Cadastro.php">Voltar</a>';


// header("Location: ../../Cadastro.php");
// exit();
?>