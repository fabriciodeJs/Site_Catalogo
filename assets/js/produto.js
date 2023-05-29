function mostraVideo() {
  const imgElement = document.querySelector('#img');
  const videoElement = document.querySelector('#video');
  const botaoPlay = document.querySelector('#botao-play');
  const botaoImg = document.querySelector('#botao-img');

  if (imgElement.style.display === 'flex') {
    imgElement.style.display = 'none';
    videoElement.style.display = 'flex';
    botaoPlay.style.display = 'none';
    botaoImg.style.display = 'flex';
  }else{
    imgElement.style.display = 'flex';
    videoElement.style.display = 'none';
    botaoPlay.style.display = 'flex';
    botaoImg.style.display = 'none';
    videoElement.pause();
  }
  
}
