const inputSearch = document.getElementById('search-input');
const blockRecettes = document.querySelectorAll('.block-recette');

inputSearch.addEventListener('keyup', () => {
    let searchedLetters = inputSearch.value;
    correspondance(searchedLetters, blockRecettes);
})

function correspondance(letters, elements) {
    for(let i = 0; i < elements.length; i++) {  
        if(elements[i].textContent.toLowerCase().includes(letters.toLowerCase())) {
            elements[i].style.display = "block"
        } else {
            elements[i].style.display = "none"
        }
    }
}

// Récupérer le bouton
const btn = document.querySelector("#mon-bouton");

// Ajouter un écouteur d'événement sur le bouton
btn.addEventListener("click", function() {
    // Afficher une boîte de dialogue
    alert("Vous avez cliqué sur le bouton !");
});



  

