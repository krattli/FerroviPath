class MetroGame {
    constructor() {
        this.twigElements = {
            // On récupère les elements du twig depuis lesquels on va prendre des infos ou afficher des trucs
            stationInput: document.querySelector('[data-input="station"]'),
            linesCount: document.querySelector('[data-field="lines"]'),
            scoreField: document.querySelector('[data-field="score"]'),
            timeField: document.querySelector('[data-field="time"]'),
            gameArea: document.querySelector('[data-game-area]'),
        };

        // Donnés interne à l'objet Partie
        this.state = {
            discoveredStations: [],
            score: 0,
            startTime: Date.now(),
            finalTime: null,
            totalStations: 0,
            stations: [],
            lineColor: null,
            lineSymbol: null,
            victoryAchieved: false
        };

        this.initialize();
    }

    initialize() {
        // Récupère les stations depuis  ce qui a été donné à twig
        this.state.stations = Array.from(this.twigElements.gameArea.dataset.stations.split(','));
        this.state.totalStations = this.state.stations.length;

        // Récupérer la couleur et le symbole de la ligne depuis le data-attribute
        this.state.lineColor = this.twigElements.gameArea.dataset.color;
        this.state.lineSymbol = this.twigElements.gameArea.dataset.symbol;

        // Événement (lorsqu'on valide un ajout de station)
        this.twigElements.stationInput.addEventListener('keypress', this.handleInput.bind(this));

        // Mise à jour du temps en temps réel
        this.updateTime();
        setInterval(this.updateTime.bind(this), 1000);
    }

    handleInput(e) {
        if (e.key === 'Enter') {
            const input = e.target.value.trim().toLowerCase();
            e.target.value = '';
            if (!input) return;

            if (this.state.stations.includes(input)) {
                if (!this.state.discoveredStations.includes(input)) {
                    this.handleCorrectGuess(input);
                } else {
                    this.showFeedback('Station déjà découverte !', 'info');
                }
            } else {
                this.showFeedback('Station non trouvée !', 'error');
            }
        }
    }

    handleCorrectGuess(station) {
        this.state.discoveredStations.push(station);
        this.state.score += 100;
        this.updateProgress();
        this.renderMetroMap();
        this.showFeedback('Station trouvée ! +100 points', 'success');
        this.checkVictory();
    }

    updateProgress() {
        this.twigElements.linesCount.textContent =
            `${this.state.discoveredStations.length}/${this.state.totalStations}`;
        this.twigElements.scoreField.textContent = this.state.score;
    }

    updateTime() {
        // on update po le temps si la partie est gagnée
        // Sans ça, le temps s'arrête pas et l'interstice entre la fin de la partie et le moment ou on appuie sur "retour à la page d'aceuil" est compté dans
        if (this.state.victoryAchieved) return;
        const elapsed = Date.now() - this.state.startTime;
        const minutes = String(Math.floor(elapsed / 60000)).padStart(2, '0');
        const seconds = String(Math.floor((elapsed % 60000) / 1000)).padStart(2, '0');
        this.twigElements.timeField.textContent = `${minutes}:${seconds}`;
    }



    checkVictory() {
        if (this.state.discoveredStations.length === this.state.totalStations) {
            this.state.victoryAchieved = true;
            this.state.finalTime = (Date.now() - this.state.startTime) / 1000;
            this.showVictoryPopup();
        }
    }

    showVictoryPopup() {
        const popupContainer = document.createElement('div');
        popupContainer.className = 'popup-container';

        const popupContent = document.createElement('div');
        popupContent.className = 'popup-content';

        const message = document.createElement('p');
        message.textContent = 'Félicitations ! Vous avez complété la ligne !';

        const homeButton = document.createElement('button');
        homeButton.textContent = 'Retour à l\'accueil';
        homeButton.className = 'popup-button';

        // Utiliser une fonction fléchée pour conserver le contexte de `this`
        homeButton.addEventListener('click', () => {
            console.log('Button clicked, saving game data...');
            this.saveGameData(() => {
                console.log('Game data saved, redirecting...');
                this.showFeedback('Données de la partie sauvegardées.', 'success');
                window.location.href = '/';
            });
        });

        popupContent.appendChild(message);
        popupContent.appendChild(homeButton);
        popupContainer.appendChild(popupContent);
        document.body.appendChild(popupContainer);
    }




    saveGameData(callback) {
        const gameData = {
            time: this.state.finalTime,
            scorePoints: this.state.score,
            completedStations: this.state.discoveredStations,
            gameMode: 'default', // On n'a qu'un seul gamemode pour l'instant donc on s'en contentera
            idLine: this.twigElements.gameArea.dataset.lineId,
            idUser: this.twigElements.gameArea.dataset.userId
        };

        fetch('/save-game', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(gameData)
        }).then(response => response.text())
            .then(data => {
                console.log('Game saved:', data);
                if (callback) callback(); // Appeler le callback après la sauvegarde
            })
            .catch(error => console.error('Error saving game:', error));
    }



    // cette méthode nous aide à calculer l'espacement entre chaque station en fonction du nombre de stations déjà découvertes
    computeSpacing(availableWidth, discoveredCount) {
        if (discoveredCount < 2) return null; // Pas d'espacement pour une seule station

        const x = discoveredCount - 1;
        const rawSpacing = availableWidth / x;  // L'espacement minimal nécessaire pour remplir la game-area
        const maxSpacing = 150;  // Espacement maximum souhaité quand il y a très peu de stations
        const threshold = 10;    // Nombre de segments (discoveredCount - 1) à partir duquel on souhaite que l'espacement devienne rawSpacing

        // f passe de 1 pour x=1 (2 stations) à 0 pour x=threshold.
        const f = Math.max(0, Math.min(1, (threshold - x) / (threshold - 1)));

        // Interpolation linéaire : quand x est faible, on est proche de maxSpacing, et quand x approche du seuil, on tend vers rawSpacing
        const spacing = f * maxSpacing + (1 - f) * rawSpacing;

        // On s'assure que l'espacement ne dépasse jamais rawSpacing pour éviter que la ligne ne déborde.
        return Math.min(spacing, rawSpacing);
    }

    renderMetroMap() {

        // On vide d'abord la game-area (de l'ancienne carte affichée)
        this.twigElements.gameArea.innerHTML = '';

        const discovered = this.state.discoveredStations;
        if (discovered.length === 0) return; // Pas d'affichage si aucune station est découverte

        // Trier les stations découvertes selon leur ordre naturel
        const sortedDiscovered = this.state.stations.filter(station => discovered.includes(station));

        // Récupérer la largeur de la game-area et définir une petite marge pour éviter les bords
        const areaWidth = this.twigElements.gameArea.offsetWidth;
        const margin = 10;
        const availableWidth = areaWidth - 2 * margin;
        const count = sortedDiscovered.length;

        let positions = [];

        if (count === 1) {
            // Si une seule station est découverte, on centre le point
            positions.push(margin + availableWidth / 2);
        } else {
            // Calcul de l'espacement dynamique entre les stations avec la fonction computeSpacing
            const spacing = this.computeSpacing(availableWidth, count);
            // Calcul de la largeur totale occupée par le groupe de stations (pour la barre de ligne)
            const totalStationsWidth = spacing * (count - 1);
            // Calcul d'un décalage pour centrer le groupe dans la game-area
            const leftOffset = margin + (availableWidth - totalStationsWidth) / 2;
            positions = sortedDiscovered.map((_, index) => leftOffset + index * spacing);
        }

        // Si on a au moins 2 stations, dessiner la barre reliant la première et la dernière station
        if (count >= 2) {
            const bar = document.createElement('div');
            bar.className = 'metro-line';
            bar.style.left = positions[0] + 'px';
            bar.style.width = (positions[positions.length - 1] - positions[0]) + 'px';
            bar.style.backgroundColor = this.state.lineColor;
            this.twigElements.gameArea.appendChild(bar);
        }

        // Pour chaque station découverte, créer un marqueur (le point) et son label (le nom de la station)
        sortedDiscovered.forEach((station, i) => {
            // Création du marqueur
            const marker = document.createElement('div');
            marker.className = 'station-marker';
            marker.style.left = positions[i] + 'px';
            marker.style.backgroundColor = this.state.lineColor;

            // Création du label
            const label = document.createElement('div');
            label.className = 'station-label';
            label.textContent = station.charAt(0).toUpperCase() + station.slice(1);
            label.style.left = positions[i] + 'px';

            this.twigElements.gameArea.appendChild(marker);
            this.twigElements.gameArea.appendChild(label);
        });
    }

    //fonction utilisée pour afficher des petits pop up (genre "nouvelle station découverte")
    showFeedback(text, type) {
        const feedback = document.createElement('div');
        feedback.className = `feedback ${type}`;
        feedback.textContent = text;
        document.body.appendChild(feedback);
        setTimeout(() => feedback.remove(), 2000);
    }
}

    // Une partie est créée dès qu'on arrive sur la page (direct)
document.addEventListener('DOMContentLoaded', () => {
    new MetroGame();
});

function confirmAbandon(s) {
    return confirm(s);
}