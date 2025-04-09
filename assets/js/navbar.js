/*
*
* Ici, tout ce qui est relatif à la navBar
* Essentiellement sur le popup "Jouer"
* Il y a beaucoup de fonctions dynamiques à prévoir donc on les gère ici
*
* */


import { createIconeTypeTransport } from 'displayLogos.js';
import { adjustColor } from 'utilities.js'

console.log('✅ displayLogos.js bien importé (depuis navbar.js)');

const radioButtons = document.querySelectorAll('input[name="lineSelector"]');
const playButton = document.getElementById('startSelectedGameBtn');
const gameButtons = document.querySelectorAll('button[class="game-btn"]')

function styleResumeGameLink() {
    const gameLinks = document.querySelectorAll('.saved-game-link');
    gameLinks.forEach(link => styleSingleLink(link));
}

// utilisé pour styliser un lien unique (celui qui sert à reprendre une partie sauvegardée)
function styleSingleLink(link) {
    //ici on définit les constantes de couleurs dont on aura besoin (la couleur de la ligne et la couleur de la ligne en plus sombre)
    const lineColor = link.dataset.lineColor;
    const darkerColor = adjustColor(lineColor, 20);
    // ici on récupère les éléments de twig dont on changera le visuel
    const button = link.querySelector('.button-visual');
    const title = link.querySelector('.savedGame-button-title');
    button.style.borderColor = lineColor;
    // on applique le style lors d'un hover de souris
    link.addEventListener('mouseenter', () => {
        button.style.backgroundColor = lineColor;
        button.style.borderColor = darkerColor;
        title.style.borderRightColor = darkerColor;
    });
    // et bien sur il faut enlever ce même style lorsque la souris quitte le bouton
    link.addEventListener('mouseleave', () => {
        button.style.backgroundColor = 'white';
        button.style.borderColor = lineColor;
        title.style.borderRightColor = 'transparent';
    });
}

//créé avec le js de l'autre fichier les logos de chaque stations
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.line-symbol-container').forEach(container => {
        const lineId = container.dataset.for;
        const input = document.getElementById(lineId);

        const symbol = input.dataset.symbol;
        const color = input.dataset.color;
        const size = parseInt(input.dataset.size, 10) || 50;

        const logo = createIconeTypeTransport(color, size, symbol);
        logo.style.cursor = 'pointer';
        logo.setAttribute('data-for', input.id);
        logo.addEventListener('click', () => input.click());

        container.appendChild(logo);
    });
});

// Utilisée pour mettre des borders foncées au Symbole de ligne selectioné dans une nouvelle partie
function updateBorders() {
    radioButtons.forEach(radio => {
        const container = radio.parentElement.querySelector('.line-Symbol');
        if (!container) return;
        if (radio.checked) {
            const color = radio.getAttribute('data-color');
            container.style.borderWidth = "4px";
            container.style.borderStyle = 'solid';
            container.style.borderColor = adjustColor(color, 20);
        } else {
            container.style.borderColor = 'transparent';
        }
    });
}

// sert à
function updatePlayButtonState() {
    const selectedLine = document.querySelector('input[name="lineSelector"]:checked');
    playButton.disabled = !selectedLine;
    updateBorders()
}

radioButtons.forEach(radio => {
    radio.addEventListener('change', updatePlayButtonState);
});
gameButtons.forEach(button => {
    button.addEventListener('click', (event) => {
        const gameId = event.target.getAttribute('data-game-id');
        window.location.href = `/resume-game/${gameId}`;
    });
});

//dans la partie nouvelle partie, on change le lien du bouton "jouer" pour qu'il amène vers la page de jeu avec la bonne ligne
playButton.addEventListener('click', () => {window.location.href = `/game/${document.querySelector('input[name="lineSelector"]:checked').value}`;});
document.addEventListener('DOMContentLoaded',styleResumeGameLink);

updatePlayButtonState();