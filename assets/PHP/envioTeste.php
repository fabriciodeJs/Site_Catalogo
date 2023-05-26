<?php
include_once('Conexao.php');
try {
  //APAGA A QUERY DO BANCO CASO AJA ERRO - 1
  $conn->beginTransaction();

  //VALIDADO INPUTS E ATRIBUINDO A VARIÁVEIS
  if (isset($_POST['nomeProduto']) and $_POST['codigoProduto'] and $_POST['descricaoProduto'] and $_POST['valorProduto']) {
    $nomeProduto = $_POST['nomeProduto'];
    $codigoProduto = $_POST['codigoProduto'];
    $descricaoProduto = $_POST['descricaoProduto'];
    $valorProduto = $_POST['valorProduto'];

    // VERIFICA SE O CÓDIGO JÁ EXISTE NO BANCO
    $query_verificarCodigo = "SELECT COUNT(*) FROM produto WHERE CODIGO = ?";
    $stmt_verificarCodigo = $conn->prepare($query_verificarCodigo);
    $stmt_verificarCodigo->bindValue(1, $codigoProduto, PDO::PARAM_STR);
    $stmt_verificarCodigo->execute();
    if ($count = $stmt_verificarCodigo->fetchColumn() > 0) {
      throw new Exception("O código do produto já existe no banco de dados.");
    }

    //SALVANDO ARQUIVOS NO BANCO
    $query_produto = "INSERT INTO produto(CODIGO, NOME, DESCRICAO, VALOR) VALUES (?, ?, ?, ?)";
    $stmt_envioProduto = $conn->prepare($query_produto);
    $stmt_envioProduto->bindValue(1, $codigoProduto, PDO::PARAM_STR);
    $stmt_envioProduto->bindValue(2, $nomeProduto, PDO::PARAM_STR);
    $stmt_envioProduto->bindValue(3, $descricaoProduto, PDO::PARAM_STR);
    $stmt_envioProduto->bindValue(4, $valorProduto, PDO::PARAM_STR);
    if (!$stmt_envioProduto->execute()){
      throw new Exception("Ao fazer Upload dos dados!");
      die();
    }
    
    //VALIDAÇÃO DE ENVIO DE IMAGEM
    if(!isset($_FILES['imagemProduto'])){
      throw new Exception("No envio da Imagem do formulario!");
      die();
    }
      
    //RECEBENDO IMAGEM DO FORMULARIO
    $imagemProduto = $_FILES['imagemProduto'];

    //PASTA QUE SERA SALVO A IMAGEM
    $pastaServ = "../img/teste/$codigoProduto/";

    //CRIANDO PASTA
    if (!mkdir($pastaServ, 0755, true)){
      throw new Exception("Ao criar a pasta para salvar a imagem,
                          verifique se já não existe uma pasta $codigoProduto no Servidor.");
      die();
    }

    //VARIAVEL DE CONTROLE DE UPDATE
    $numeroColuna = 1;

    for ($i = 0; $i < count($imagemProduto['name']); $i++) {
      //GERANDO UM NOVO NOME PARA IMAGEM
      $nomeDaImg = $imagemProduto['name'][$i];
      $novoNomeImg = uniqid();
      $extensao = strtolower(pathinfo($nomeDaImg, PATHINFO_EXTENSION));

      //VALIDANDO TIPO DO ARQUIVO
      if ($extensao != 'jpg' and $extensao != 'png' and $extensao != 'webp'){
        throw new Exception("ADICIONE IMAGEM DO TIPO (PNG, JPG OU WEBP)");
        die();
      }

      //SALVANDO IMAGEM NA PASTA E O CAMINHO NO BANCO DE DADOS
      $caminhoDaImgServidor = $pastaServ . $novoNomeImg . '.' . $extensao;
      $caminhoDaImgIndex = 'assets/img/teste/' . $codigoProduto . '/' . $novoNomeImg . '.' . $extensao;

      if (!move_uploaded_file($imagemProduto["tmp_name"][$i], $caminhoDaImgServidor)){
        throw new Exception("Ao Salvar imagem no Servidor");
        die();
      }
      
      //INSERINDO A PRIMEIRA IMAGEM NO BANCO
      if($numeroColuna === 1){
        $query_imagem = "INSERT INTO imagens(CODIGO_PRODUTO, IMAGEM_$numeroColuna) VALUES (?, ?)";
        $stmt_imagem = $conn->prepare($query_imagem);
        $stmt_imagem->bindValue(1, $codigoProduto, PDO::PARAM_STR);
        $stmt_imagem->bindValue(2, $caminhoDaImgIndex, PDO::PARAM_STR);
        if (!$stmt_imagem->execute()){
          if (is_dir($pastaServ)) {
          array_map('unlink', glob("$pastaServ/*.*"));
            rmdir($pastaServ);
          }
          throw new Exception("Ao salvar dados no banco.");
          die();
        }
      } 
      
      if($numeroColuna > 1){
        //ADICIONANDO AS OUTRAS IMAGEM NO BANCO
        $query_imagem = "UPDATE imagens SET IMAGEM_$numeroColuna = ? WHERE CODIGO_PRODUTO = ?";
        $stmt_imagem = $conn->prepare($query_imagem);
        $stmt_imagem->bindValue(1, $caminhoDaImgIndex, PDO::PARAM_STR);
        $stmt_imagem->bindValue(2, $codigoProduto, PDO::PARAM_STR);
        if (!$stmt_imagem->execute()){
          if (is_dir($pastaServ)) {
            array_map('unlink', glob("$pastaServ/*.*"));
            rmdir($pastaServ);
          }
          throw new Exception("Ao fazer update das imagens.");
          die();
        }
      }
      $numeroColuna++;
    }
    //PERMITE A QUERY CASO NÃO AJA ERRO - 2
    $conn->commit();
    header("Location: ../../Cadastro.php");
  }
} catch (Exception $e) {
  //APAGA A QUERY DO BANCO CASO AJA ERRO - 3
  $conn->rollBack();
  echo "Erro: " . $e->getMessage();
} 

echo '<br>';
echo '<br>';
echo '<h1><a href="../../Cadastro.php">Voltar</a></h1>';
