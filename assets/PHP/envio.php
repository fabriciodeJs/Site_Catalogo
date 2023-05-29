<?php
/*
include('Conexao.php');

// VALIDANDO INPUTS E ATRIBUIDO A VARIAVEIS
if (isset($_POST['nomeProduto']) and $_POST['codigoProduto'] and $_POST['descricaoProduto'] and $_POST['valorProduto']) {
  $nomeProduto = $_POST['nomeProduto'];
  $codigoProduto = $_POST['codigoProduto'];
  $descricaoProduto = $_POST['descricaoProduto'];
  $valorProduto = $_POST['valorProduto'];
  

  // VALIDAÇÃO DE ENVIO DE IMAGEM
  if (isset($_FILES['imagemProduto']) isset($_FILES['videoProduto'])) {
    //RECEBENDO IMG
    $imagemProduto = $_FILES['imagemProduto'];
    $videoProduto = $_POST['videoProduto'];
    ;

    //PASTA QUE SERA SALVO A IMAGEM 
    $pastaServ = "../img/teste/$codigoProduto/";

    //CRIANDO PASTA
    try {
      if (!mkdir($pastaServ, 0755, true))
        throw new Exception("Erro ao criar a pasta para salvar a imagem.");
    } catch (Exception $e) {
      die("Erro: " . $e->getMessage());
    }

    for ($i = 0; $i < count($imagemProduto['name']); $i++) {

      //GERANDO UM NOVO NOME PARA IMAGEM
      $nomeDaImg = $imagemProduto['name'][$i];
      $novoNomeImg = uniqid();
      $extensao = strtolower(pathinfo($nomeDaImg, PATHINFO_EXTENSION));

      //VALIDANDO TIPO DO ARQUIVO
      try {
        if ($extensao != 'jpg' and $extensao != 'png' and $extensao != 'webp')
          throw new Exception("ADICIONE IMAGEM DO TIPO (PNG, JPG OU WEBP)");
      } catch (Exception $e) {
        die('Erro: ' . $e->getMessage());
      }

      //SALVANDO IMAGEM NA PASTA E O CAMINHO NO BANCO DE DADOS
      $caminhoDaImgServidor = $pastaServ . $novoNomeImg . '.' . $extensao;
      $caminhoDaImgIndex = 'assets/img/teste/' . $codigoProduto . '/' . $novoNomeImg . '.' . $extensao;

      //SALVANDO NA PASTA
      try {
        if (!move_uploaded_file($imagemProduto["tmp_name"][$i], $caminhoDaImgServidor))
          throw new Exception("Erro ao mover o arquivo de imagem para a pasta de destino.");
      } catch (\Throwable $th) {
        die("Erro: " . $e->getMessage());
      }

      //ENVIO DA IMAGEM PARA SERVIDOR
      try {
        $query_imagem =
        "INSERT INTO imagens(CODIGO_PRODUTO,IMAGEM_1,IMAGEM_2, IMAGEM_3, IMAGEM_4, IMAGEM_5, IMAGEM_6) 
        VALUES 
        ('{$codigoProduto}','{$caminhoDaImgIndex}')";

        $envioImg = $conn->prepare($query_imagem);

        if (!$envioImg->execute()) {
          throw new Exception("Falha ao Fazer Upload das Imagens");
        }
      } catch (Exception $e) {
        die('Erro: ' . $e->getMessage());
      }
    }
  }
  //SALVANDO ARQUIVOS NO BANCO SEM IMAGEM
  try {
    $query_produto = "INSERT INTO produto(CODIGO, NOME, DESCRICAO, VALOR)
    VALUES ('{$codigoProduto}','{$nomeProduto}', '{$descricaoProduto}', '{$valorProduto}')";

    $envioProduto = $conn->prepare($query_produto);

    if (!$envioProduto->execute())
      throw new Exception("Falha ao fazer o upload do produto.");
  } catch (Exception $e) {
    die("Erro: " . $e->getMessage());
  }
}
echo header("location: ../../Cadastro.php");
// echo '<h1>Prencha todos os Campos</h1>';
// echo '<a href="../../Cadastro.php">Voltar</a>'; 

*/
?>