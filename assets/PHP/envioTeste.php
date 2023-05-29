<?php
include_once('Conexao.php');
try {
  //APAGA A QUERY DO BANCO CASO HAJA ERRO - 1
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
    if (!$stmt_envioProduto->execute()) {
      throw new Exception("Ao fazer Upload dos dados!");
      die();
    }

    //VALIDAÇÃO DE ENVIO DE IMAGEM E VIDEO
    if (!isset($_FILES['imagemProduto'])) {
      throw new Exception("No envio da Imagem do formulario!");
      die();
    }

    //RECEBENDO IMAGEM DO FORMULARIO
    $imagemProduto = $_FILES['imagemProduto'];

    //PASTA QUE SERA SALVO A IMAGEM
    $pastaServ = "../img/teste/$codigoProduto/";

    //RECUPERANDO ULTIMO ID CADASTRADO
    // $id_Produto = $conn->lastInsertId()

    //CRIANDO PASTA
    if (!mkdir($pastaServ, 0755, true)) {
      throw new Exception("Ao criar a pasta para salvar a imagem,
                          verifique se já não existe uma pasta $codigoProduto no Servidor.");
      die();
    }

    //VARIAVEL DE CONTROLE DE UPDATE
    $numeroColuna = 1;

    /*                   ENVIO DA IMAGEM                  */

    for ($i = 0; $i < count($imagemProduto['name']); $i++) {
      //GERANDO UM NOVO NOME PARA IMAGEM
      $nomeDaImg = $imagemProduto['name'][$i];
      $novoNomeImg = uniqid();
      $extensaoImg = strtolower(pathinfo($nomeDaImg, PATHINFO_EXTENSION));

      //VALIDANDO TIPO DO ARQUIVO
      if ($extensaoImg  != 'jpg' && $extensaoImg != 'png' && $extensaoImg != 'webp') {
        throw new Exception("ADICIONE IMAGEM DO TIPO (PNG, JPG OU WEBP)");
        if (is_dir($pastaServ)) {
          array_map('unlink', glob("$pastaServ/*.*"));
          rmdir($pastaServ);
        }
        die();
      }

      //SALVANDO IMAGEM NA PASTA E O CAMINHO NO BANCO DE DADOS
      $caminhoDaImgServidor = $pastaServ . $novoNomeImg . '.' . $extensaoImg;
      $caminhoDaImgIndex = 'assets/img/teste/' . $codigoProduto . '/' . $novoNomeImg . '.' . $extensaoImg;

      //VALIDADO SE FOI SALVO NO SERVIDOR
      if (!move_uploaded_file($imagemProduto["tmp_name"][$i], $caminhoDaImgServidor)) {
        throw new Exception("Ao Salvar imagem no Servidor");
        die();
      }

      //INSERINDO A PRIMEIRA IMAGEM NO BANCO
      if ($numeroColuna === 1) {
        $query_imagem = "INSERT INTO imagens(CODIGO_PRODUTO, IMAGEM_$numeroColuna) VALUES (?, ?)";
        $stmt_imagem = $conn->prepare($query_imagem);
        $stmt_imagem->bindValue(1, $codigoProduto, PDO::PARAM_STR);
        $stmt_imagem->bindValue(2, $caminhoDaImgIndex, PDO::PARAM_STR);
        if (!$stmt_imagem->execute()) {
          if (is_dir($pastaServ)) {
            array_map('unlink', glob("$pastaServ/*.*"));
            rmdir($pastaServ);
          }
          throw new Exception("Ao salvar dados no banco.");
          die();
        }
      }else{
        //ADICIONANDO AS OUTRAS IMAGEM NO BANCO
        $query_imagem = "UPDATE imagens SET IMAGEM_$numeroColuna = ? WHERE CODIGO_PRODUTO = ?";
        $stmt_imagem = $conn->prepare($query_imagem);
        $stmt_imagem->bindValue(1, $caminhoDaImgIndex, PDO::PARAM_STR);
        $stmt_imagem->bindValue(2, $codigoProduto, PDO::PARAM_STR);
        if (!$stmt_imagem->execute()) {
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

    /*                   ENVIO DO VIDEO                  */

    if (isset($_FILES['videoProduto'])) {
      //RECEBENDO VIDEO DO SERVIDOR
      $videoProduto = $_FILES['videoProduto'];

      //GERANDO UM NOVO NOME PARA VIDEO
      $nomeDovideo = uniqid();
      $extensaoVideo = strtolower(pathinfo($videoProduto['name'], PATHINFO_EXTENSION));
      echo $extensaoVideo;

      //VALIDANDO TIPO DO ARQUIVO
      if ($extensaoVideo != 'mp4' && $extensaoVideo != 'mov' && $extensaoVideo != 'mkv') {
        throw new Exception("ADICIONE VIDEO DO TIPO (MP4, MOV OU MKV)");
        if (is_dir($pastaServ)) {
          array_map('unlink', glob("$pastaServ/*.*"));
          rmdir($pastaServ);
        }
        die();
      }

      //SALVADO VIDEO NO SERVIDOR
      $caminhoDoVideoServidor = $pastaServ . $nomeDovideo . '.' . $extensaoVideo;
      $caminhoDoVideoIndex = 'assets/img/teste/' . $codigoProduto . '/' . $nomeDovideo . '.' . $extensaoVideo;

      //VALIDADO SE FOI SALVO
      if (move_uploaded_file($videoProduto["tmp_name"], $caminhoDoVideoServidor)) {
        //ADICIONANDO AS OUTRAS IMAGEM NO BANCO
        $query_video = "UPDATE imagens SET video = ? WHERE CODIGO_PRODUTO = ?";
        $stmt_video = $conn->prepare($query_video);
        $stmt_video->bindValue(1, $caminhoDoVideoIndex, PDO::PARAM_STR);
        $stmt_video->bindValue(2, $codigoProduto, PDO::PARAM_STR);
        if (!$stmt_video->execute()) {
          if (is_dir($pastaServ)) {
            array_map('unlink', glob("$pastaServ/*.*"));
            rmdir($pastaServ);
          }
          throw new Exception("Ao fazer update do Video.");
          die();
        }
      }else{
        throw new Exception("Ao Salvar Video no Servidor");
        die();
      }
    }

    //PERMITE A QUERY CASO NÃO HAJA ERRO - 2
    $conn->commit();
    header("Location: ../../Cadastro.php");
  }
} catch (Exception $e) {
  //APAGA A QUERY DO BANCO CASO HAJA ERRO - 3
  $conn->rollBack();
  echo "Erro: " . $e->getMessage();
}

echo '<br>';
echo '<br>';
echo '<h1><a href="../../Cadastro.php">Voltar</a></h1>';
