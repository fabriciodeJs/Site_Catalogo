<?php

include('Conexao.php');

// VALIDANDO INPUTS E ATRIBUIDO A VARIAVEIS
if (isset($_POST['nomeProduto']) and $_POST['codigoProduto'] and $_POST['descricaoProduto'] and $_POST['valorProduto']) {
  $nomeProduto = $_POST['nomeProduto'];
  $codigoProduto = $_POST['codigoProduto'];
  $descricaoProduto = $_POST['descricaoProduto'];
  $valorProduto = $_POST['valorProduto'];

  // VALIDAÇÃO DE ENVIO DE IMAGEM
  if (isset($_FILES['imagemProduto'])) {
    $imagemProduto = $_FILES['imagemProduto'];

    //PASA QUE SERA SALVO A IMAGEM E GERANDO NOME UNICO
    $pastaServ = '../img/';
    $nomeDaImg = $imagemProduto['name'];
    $novoNomeImg = uniqid();
    $extensao = strtolower(pathinfo($nomeDaImg, PATHINFO_EXTENSION));

    //VALIDANDO TIPO DO ARQUIVO
    if ($extensao != 'jpg' and $extensao != 'png' and $extensao != 'webp')
      die("ADICIONE IMAGEM DO TIPO (PNG, JPG OU WEBP)");
  
    //SALVANDO IMAGEM NA PASTA E O CAMINHO NO BANCO DE DADOS
    $caminhoDaImgServidor = $pastaServ . $novoNomeImg . '.' . $extensao;
    $caminhoDaImgIndex = 'assets/img/'. $novoNomeImg . '.' . $extensao;
    $salvoNaPasta = move_uploaded_file($imagemProduto["tmp_name"], $caminhoDaImgServidor);
    if ($salvoNaPasta) {
      $cadastro = mysqli_query($mysqli, "INSERT INTO produto(CODIGO, NOME, DESCRICAO, VALOR, IMAGEM)
        VALUES ({$codigoProduto},'{$nomeProduto}', '{$descricaoProduto}', '{$valorProduto}', '{$caminhoDaImgIndex}')");
      echo header("location: ../../Cadastro.php");
    } else {
      echo "<h1>FALHA AO SALVAR</h1>";
    }
    die();
  }
  //SALVANDO ARQUIVOS NO BANCO SEM IMAGEM
  $cadastro = mysqli_query($mysqli, "INSERT INTO produto(CODIGO, NOME, DESCRICAO, VALOR, IMAGEM)
  VALUES ({$codigoProduto},'{$nomeProduto}', '{$descricaoProduto}', '{$valorProduto}')");
  die();
}

echo '<h1>Prencha todos os Campos</h1>';
echo '<a href="../../Cadastro.php">Voltar</a>';