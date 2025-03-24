class MetroGame {
    constructor() {
        this.dom = {
            stationInput: document.querySelector('[data-input="station"]'),
            linesCount: document.querySelector('[data-field="lines"]'),
            scoreField: document.querySelector('[data-field="score"]'),
            timeField: document.querySelector('[data-field="time"]'),
            gameArea: document.querySelector('[data-game-area]'),
        };

        // État du jeu
        this.state = {
            discoveredStations: new Set(),
            score: 0,
            startTime: Date.now(),
            totalStations: 0,
            stations: [],
            lineColor: null,
            lineSymbol: null
        };

        this.initialize();
    }

    initialize() {
        // Récupère les stations depuis le dataset (toujours sous forme de liste)
        this.state.stations = Array.from(this.dom.gameArea.dataset.stations.split(','))
            .map(s => s.toLowerCase().trim());
        this.state.totalStations = this.state.stations.length;

        // Récupérer la couleur et le symbole de la ligne depuis le data-attribute
        this.state.lineColor = this.dom.gameArea.dataset.color;
        this.state.lineSymbol = this.dom.gameArea.dataset.symbol;

        // Initialiser l'affichage de la ligne de métro
        this.renderMetroLine();

        // Événements
        this.dom.stationInput.addEventListener('keypress', this.handleInput.bind(this));

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
                // Vérifier si la station n'est pas déjà découverte
                if (!this.state.discoveredStations.has(input)) {
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
        this.state.discoveredStations.add(station);
        this.state.score += 100;
        this.updateProgress();
        this.renderMetroMap();
        this.showFeedback('Station trouvée ! +100 points', 'success');
    }

    updateProgress() {
        this.dom.linesCount.textContent =
            `${this.state.discoveredStations.size}/${this.state.totalStations}`;
        this.dom.scoreField.textContent = this.state.score;
    }

    updateTime() {
        const elapsed = Math.floor((Date.now() - this.state.startTime) / 1000);
        const minutes = String(Math.floor(elapsed / 60)).padStart(2, '0');
        const seconds = String(elapsed % 60).padStart(2, '0');
        this.dom.timeField.textContent = `${minutes}:${seconds}`;
    }

    renderMetroLine() {
        // On crée un élément pour la ligne de métro
        this.dom.gameArea.innerHTML = `<div class="metro-line" style="background-color: ${this.state.lineColor};"></div>`;
    }

    renderMetroMap() {
        // On commence par recréer la ligne
        this.renderMetroLine();

        // Dimensions et calcul de positions
        const areaWidth = this.dom.gameArea.offsetWidth;
        const total = this.state.totalStations;

        // Pour chaque station découverte, on ajoute un marqueur sur la ligne
        this.state.stations.forEach((station, index) => {
            if (this.state.discoveredStations.has(station)) {
                // Calcul de la position en % (supposant un espacement uniforme)
                const leftPercent = (index / (total - 1)) * 100;

                // Création du marqueur
                const marker = document.createElement('div');
                marker.className = 'station-marker';
                marker.style.left = `${leftPercent}%`;
                marker.style.backgroundColor = this.state.lineColor;

                // Création de l'étiquette (nom de la station)
                const label = document.createElement('div');
                label.className = 'station-label';
                label.textContent = station.charAt(0).toUpperCase() + station.slice(1);

                // Ajout du label au marqueur
                marker.appendChild(label);
                this.dom.gameArea.appendChild(marker);
            }
        });
    }

    showFeedback(text, type) {
        const feedback = document.createElement('div');
        feedback.className = `feedback ${type}`;
        feedback.textContent = text;
        document.body.appendChild(feedback);
        setTimeout(() => feedback.remove(), 2000);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new MetroGame();
});
