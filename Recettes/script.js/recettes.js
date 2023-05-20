const titreAssaisonnement = document.querySelector('.marinade h3');
const titreInstructions = document.querySelector('.instructions h3');

if(titreAssaisonnement) {
    titreAssaisonnement.addEventListener('click', () => {
        titreAssaisonnement.classList.toggle('active');
    })
}

titreInstructions.addEventListener('click', () => {

    titreInstructions.classList.toggle('active');

})