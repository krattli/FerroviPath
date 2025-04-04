const radioButtons = document.querySelectorAll('input[name="lineSelector"]');
const gameSelector = document.getElementById('gameSelector');
const playButton = document.getElementById('startSelectedGameBtn');

function darkenColor(color, percent) {
    color = color.replace('#', '');

    let r = parseInt(color.substring(0, 2), 16);
    let g = parseInt(color.substring(2, 4), 16);
    let b = parseInt(color.substring(4, 6), 16);

    r = Math.floor(r * (1 - percent / 100));
    g = Math.floor(g * (1 - percent / 100));
    b = Math.floor(b * (1 - percent / 100));

    r = r.toString(16).padStart(2, '0');
    g = g.toString(16).padStart(2, '0');
    b = b.toString(16).padStart(2, '0');

    return `#${r}${g}${b}`;
}

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

const updatePlayButtonState = () => {
    const activeTab = document.querySelector('.tab-pane.active');
    if (activeTab.id === 'newGameTab') {
        const selectedLine = document.querySelector('input[name="lineSelector"]:checked');
        playButton.disabled = !selectedLine;
    } else if (activeTab.id === 'savedGameTab') {
        playButton.disabled = !gameSelector || !gameSelector.value;
    }

    updateBorders();
};

radioButtons.forEach(radio => {
    radio.addEventListener('change', updatePlayButtonState);
});

if (gameSelector) gameSelector.addEventListener('change', updatePlayButtonState);

document.getElementById('gameTab').addEventListener('click', updatePlayButtonState);

playButton.addEventListener('click', () => {
    const activeTab = document.querySelector('.tab-pane.active');
    if (activeTab.id === 'newGameTab') {
        const selectedLine = document.querySelector('input[name="lineSelector"]:checked');
        if (selectedLine) {
            window.location.href = `/game/${selectedLine.value}`;
        }
    } else if (activeTab.id === 'savedGameTab' && gameSelector && gameSelector.value) {
        window.location.href = `/resume-game/${gameSelector.value}`;
    }
});