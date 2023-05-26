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
      const imgElement = document.querySelector("#img");
      imgElement.src = imagens[indice  - 1];
      imgElement.alt = "<?php echo $dado['NOME']; ?>";
    }
    //NAVEGAR ENTRE AS FOTOS
    function navegar(direcao) {
      indice  += direcao;
      // VERIFICA SE CHEGOU AO LIMITE DE IMG
      if (indice  < 1) {
        indice  = totalImages;
      } else if (indice  > totalImages) {
        indice = 1;
      }
      exibirImagem();
    }
    // MOSTRA AS IMG QUANDO A PAGINA CARREGA
    totalImages = imagens.length;
    exibirImagem();