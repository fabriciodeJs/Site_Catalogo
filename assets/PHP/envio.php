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
    //RECEBENDO IMG
    $imagemProduto = $_FILES['imagemProduto'];

    //RECUPERANDO ULTIMO ID CADASTRADO
    // $id_Produto = $conn->lastInsertId();

    //PASTA QUE SERA SALVO A IMAGEM 
    $pastaServ = "../img/teste/$codigoProduto/";

    //CRIANDO PASTA
    mkdir($pastaServ, 0755);

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

      //SALVANDO NA PASTA
      if (move_uploaded_file($imagemProduto["tmp_name"][$i], $caminhoDaImgServidor)) {
  
        //ENVIO DA IMAGEM PARA SERVIDOR 
        $query_imagem = 
        "INSERT INTO imagens(CODIGO_PRODUTO,IMAGEM_1,IMAGEM_2, IMAGEM_3, IMAGEM_4, IMAGEM_5, IMAGEM_6) 
        VALUES 
        ('{$codigoProduto}','{$caminhoDaImgIndex}')";

        $envioImg = $conn->prepare($query_imagem);

        if ($envioImg->execute()) {
          echo header("location: ../../Cadastro.php");
        } else {
          echo "<h1>FALHA AO SALVAR</h1>";
        }
      }
    }
  }

  // if(){
  //   // echo header("location: ../../Cadastro.php");
  //   // die();
  //   }

  //SALVANDO ARQUIVOS NO BANCO SEM IMAGEM
  $query_produto = "INSERT INTO produto(CODIGO, NOME, DESCRICAO, VALOR)
   VALUES ('{$codigoProduto}','{$nomeProduto}', '{$descricaoProduto}', '{$valorProduto}')";

  $envioProduto = $conn->prepare($query_produto);

  if (!$envioProduto->execute()) {
    die('<h1>Falha ao fazer Upload!</h1>');
  }
}

echo '<h1>Prencha todos os Campos</h1>';
echo '<a href="../../Cadastro.php">Voltar</a>';





// $cadastra_imgs = mysqli_query($conn, );
        // $cadastro_prod = mysqli_query($mysqli, "INSERT INTO produto(CODIGO, NOME, DESCRICAO, VALOR, IMAGEM)
        //   VALUES ({$codigoProduto},'{$nomeProduto}', '{$descricaoProduto}', '{$valorProduto}')");}



 // $cadastro_prod = mysqli_query($mysqli, "INSERT INTO produto(CODIGO, NOME, DESCRICAO, VALOR)
  // VALUES ({$codigoProduto},'{$nomeProduto}', '{$descricaoProduto}', '{$valorProduto}')");
  // die();