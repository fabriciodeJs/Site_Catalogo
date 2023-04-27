
function criaImg(){
    const img = document.createElement('img');

    return img;
}
function criaH3(){
    const h3 = document.createElement('h3');

    return h3;
}
function criaP(){
    const p = document.createElement('p');

    return p;
}
function criaDiv(){
    const div = document.createElement('div');

    return div;
}




const saida = document.querySelector('#saida')


    const img = criaImg();
    const h3 = criaH3();
    const p = criaP();  
    const divContainer = criaDiv();
    const divCard = criaDiv();


    img.src = 'assets/img/Bomba.png'
    h3.innerText = 'Bomba Hidraulica'
    p.innerText = 'Lorem ipsum dolor sit amet consectetur adipisicing.'

    divContainer.classList.add('container-item');
    divCard.classList.add('card-item');
  

    divCard.appendChild(img);
    divCard.appendChild(h3);
    divCard.appendChild(p);
    divContainer.appendChild(divCard);
    console.log(divContainer)
    saida.appendChild(divContainer)
    


   