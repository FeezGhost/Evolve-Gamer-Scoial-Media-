const button=document.querySelector('.b1');
const popupWrapper=document.querySelector('.popup-wrapper');
const close = document.querySelector('.popup-close');

button.addEventListener('click', ()=>{
    popupWrapper.style.display='block';
});

close.addEventListener('click', () => {
    popupWrapper.style.display = 'none';
});