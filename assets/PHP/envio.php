<?php

    include('Conexao.php');

      $nomeProduto = $_POST['nomeProduto'];
      $codigoProduto = $_POST['codigoProduto'];
      $descricaoProduto = $_POST['descricaoProduto'];
      $valorProduto = $_POST['valorProduto'];
      $imagemProduto = $_POST['imagemProduto'];
    
      if($nomeProduto and $codigoProduto and $descricaoProduto and $valorProduto){

      $cadastro = mysqli_query($mysqli, "INSERT INTO produto(CODIGO, NOME, DESCRICAO, VALOR, IMAGEM)
       VALUES ({$codigoProduto},'{$nomeProduto}', '{$descricaoProduto}', '{$valorProduto}', '{$imagemProduto}')");
  
       echo "Produto Cadastrado";

      }else {
        echo "Preencha os Dados";
      }