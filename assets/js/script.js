const pesquisa = document.querySelector('#pesquisar');

function gerarPagina(cod){
    localStorage.setItem('codigo', cod);

    window.location.href = 'Produto.php?codigo=' + encodeURIComponent(cod);

}

pesquisa.addEventListener("keydown", (e) => {
    if (e.key === "Enter") pesquisarProduto();
});

function pesquisarProduto(){
    window.location = 'index.php?pesquisar=' + pesquisa.value;

    pesquisa.value = '';
}