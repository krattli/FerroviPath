class MetroGame {
    constructor() {
        this.dom = {
            stationInput: document.querySelector('[data-input="station"]'),
            linesCount: document.querySelector('[data-field="lines"]'),
            scoreField: document.querySelector('[data-field="score"]'),
            timeField: document.querySelector('[data-field="time"]'),
            gameArea: document.querySelector('[data-game-area]'),
        };

        this.state = {
            discoveredStations: new Set(),
            score: 0,
            startTime: Date.now(),
            totalStations: 0,
            stations: []
        };

        this.initialize();
    }

    initialize() {
        this.state.stations = Array.from(this.dom.gameArea.dataset.stations.split(','))
            .map(s => s.toLowerCase().trim());

        this.state.totalStations = this.state.stations.length;

        this.dom.stationInput.addEventListener('keypress', this.handleInput.bind(this));

        this.updateTime();
        setInterval(this.updateTime.bind(this), 1000);

        this.renderStations();
    }

    handleInput(e) {
        if (e.key === 'Enter') {
            const input = e.target.value.trim().toLowerCase();
            e.target.value = '';

            if (!input) return;

            if (this.state.stations.includes(input)) {
                this.handleCorrectGuess(input);
            } else {
                this.showFeedback('Station non trouvée !', 'error');
            }
        }
    }

    handleCorrectGuess(station) {
        this.state.discoveredStations.add(station);
        this.state.score += 100;

        this.updateProgress();
        this.renderStations();
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

    renderStations() {
        this.dom.gameArea.innerHTML = this.state.stations
            .map(station => `
        <div class="station-item" data-status="${
                this.state.discoveredStations.has(station) ? 'discovered' : 'hidden'
            }">
          ${this.state.discoveredStations.has(station)
                ? station.charAt(0).toUpperCase() + station.slice(1)
                : '?'}
        </div>
      `).join('');
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