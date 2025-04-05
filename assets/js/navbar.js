console.log('✅ navbar.js bien importé (depuis navbar.js)');

import { darkenColor } from 'displayLogos.js';

console.log('✅ displayLogos.js bien importé (depuis navbar.js)');

const radioButtons = document.querySelectorAll('input[name="lineSelector"]');
const playButton = document.getElementById('startSelectedGameBtn');



function updateBorders() {
    radioButtons.forEach(radio => {
        if (radio.checked) {
            const color = radio.getAttribute('data-color');
            radio.nextElementSibling.style.borderColor = darkenColor(color, 30);
        } else {
            radio.nextElementSibling.style.borderColor = 'transparent';
        }
    });
}

function updatePlayButtonState() {
    const activeTab = document.querySelector('.tab-pane.active');
    if (activeTab.id === 'newGameTab') {
        const selectedLine = document.querySelector('input[name="lineSelector"]:checked');
        playButton.disabled = !selectedLine;
    } else if (activeTab.id === 'savedGameTab') {
        playButton.disabled = !gameButtons || gameButtons.length === 0;
    }
    updateBorders()
}

radioButtons.forEach(radio => {
    radio.addEventListener('change', updatePlayButtonState);
});

document.getElementById('gameTab').addEventListener('click', updatePlayButtonState);

playButton.addEventListener('click', () => {window.location.href = `/game/${document.querySelector('input[name="lineSelector"]:checked').value}`;});

gameButtons.forEach(button => {
    button.addEventListener('click', (event) => {
        const gameId = event.target.getAttribute('data-game-id');
        window.location.href = `/resume-game/${gameId}`;
    });
});

document.getElementById('gameTab').addEventListener('click', updatePlayButtonState);

updatePlayButtonState();