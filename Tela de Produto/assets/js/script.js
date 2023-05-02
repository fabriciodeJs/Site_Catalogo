function gerarPagina(cod){

    localStorage.setItem('codigo', cod);

    window.location.href = 'Produto.php?codigo=' + encodeURIComponent(cod);

}

