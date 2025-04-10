import {appendCorrespondances, createIconeStation, createIconeTypeTransport, createTransportTypeLogo} from "displayLogos.js";
import {getPositions, showVictoryPopup, showFeedback} from "utilities.js";

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
            correspondances: new Map(),
            lineColor: null,
            lineSymbol: null,
            victoryAchieved: false
        };
        this.showFeedback=showFeedback;
        this.initialize();
    }

    initialize() {
        const gameArea = this.twigElements.gameArea;

        // Récupère les stations depuis ce qui a été donné à twig
        this.state.stations = Array.from(gameArea.dataset.stations.split(','));
        this.state.totalStations = this.state.stations.length;

        // Récupérer les correspondances pour chaque stations
        const correspondancesRaw = gameArea.dataset.correspondances;
        if (correspondancesRaw) {
            const correspondancesParsed = JSON.parse(correspondancesRaw);
            correspondancesParsed.forEach(entry => {
                this.state.correspondances.set(entry.name, entry.lines);
            });
        }
        //console.log(this.state.correspondances)

        // Récupérer la couleur et le symbole de la ligne depuis le data-attribute
        this.state.lineColor = gameArea.dataset.color;
        this.state.lineSymbol = gameArea.dataset.symbol;

        // récupère la partie si on est sur la page de jeu pour continuer à jouer à une partie sauvegardée
        if (gameArea.dataset.resume === 'true') {
            // On récupère depuis le twig les stations déja découvertes pour les mettre dans cette instance game js
            const discovered = gameArea.dataset.discovered;
            this.state.discoveredStations = discovered.split(',');
            this.state.score = this.state.discoveredStations.length * 100;
            this.updateProgress()
            this.state.startTime = Date.now() - (parseFloat(gameArea.dataset.time) * 1000);
            this.renderMetroMap();
        }

        // Événement (lorsqu'on valide un ajout de station)
        this.twigElements.stationInput.addEventListener('keypress', this.handleInput.bind(this));

        this.twigElements.gameArea.appendChild(createTransportTypeLogo("metro", 50));
        const icon = createIconeTypeTransport(this.state.lineColor, 50, this.state.lineSymbol);
        icon.style.marginLeft = "5px";
        this.twigElements.gameArea.appendChild(icon);

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

    validateWord(input, list) {
        if (!list.includes(input)) {
            return true;
        }
        return false
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
        if (this.state.finalTime !== null) return;
        const elapsed = Date.now() - this.state.startTime;
        const minutes = String(Math.floor(elapsed / 60000)).padStart(2, '0');
        const seconds = String(Math.floor((elapsed % 60000) / 1000)).padStart(2, '0');
        this.twigElements.timeField.textContent = `${minutes}:${seconds}`;
    }

    checkVictory() {
        if (this.state.discoveredStations.length === this.state.totalStations) {
            this.state.victoryAchieved = true;
            this.endGame(false);
        }
    }

    endGame(saveAndExit = false) {
        if (this.state.finalTime === null) {
            this.state.finalTime = (Date.now() - this.state.startTime) / 1000;
        }

        this.saveGameData(() => {
            if (saveAndExit) {
                showFeedback('Partie sauvegardée.', 'success');
                setTimeout(() => {
                    window.location.href = '/';
                }, 1000);
            } else {
                showVictoryPopup();
            }
        });
    }

    saveGameData(callback) {
        const gameArea = this.twigElements.gameArea;
        const gameData = {
            time: this.state.finalTime,
            scorePoints: this.state.score,
            completedStations: this.state.discoveredStations,
            gameMode: 'default', //On a qu'un seul gamemode pour l'instant
            idLine: gameArea.dataset.lineId,
            idUser: gameArea.dataset.userId,
            isFinished: this.state.victoryAchieved, // la partie est elle finie ou une simple sauvegarde ?
        };

        // Si on reprend une partie existante, on envoie aussi son ID
        if (gameArea.dataset.resume === 'true') {
            gameData.idGame = gameArea.dataset.gameId;
        }

        fetch('/save-game', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(gameData)
        }).then(response => response.text())
            .then(data => {
                console.log('Game saved:', data);
                if (callback) callback();
            })
            .catch(error => console.error('Error saving game:', error));
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
        const count = sortedDiscovered.length;

        // On calcule les positions de chaque icone station. Celles qui ont des correspondances peuvent prendre plus de place
        let positions = getPositions(sortedDiscovered, this.state.correspondances, areaWidth, 20)

        // Si on a au moins 2 stations, dessiner la barre reliant la première et la dernière station
        if (count >= 2) {
            const bar = document.createElement('div');
            bar.className = 'metro-line';
            bar.style.left = positions[0] + 'px';
            bar.style.width = (positions[positions.length - 1] - positions[0]) + 'px';
            bar.style.height = '6px';
            bar.style.backgroundColor = this.state.lineColor;
            this.twigElements.gameArea.appendChild(bar);
        }

        // Pour chaque station découverte, créer un marqueur (le point) et son label (le nom de la station)
        sortedDiscovered.forEach((station, i) => {

            const isTerminus = station === this.state.stations[0] || station === this.state.stations[this.state.stations.length - 1];
            const correspondances = this.state.correspondances.get(station);
            const hasCorrespondances = correspondances && correspondances.length !== 0;

            // On créé notre icone de station avec son texte et tout grâce à notre fonction externalisée
            const textLabel = station.charAt(0).toUpperCase()  + station.slice(1);
            const stationIcon = createIconeStation(this.state.lineColor, 20, textLabel, isTerminus, hasCorrespondances);

            // Puis on la positionne bien comme il faut sur la zone de jeu
            stationIcon.style.left = positions[i] + 'px';

            // Si la station a des correspondances, elles seront ajoutées à la div html station et affichées à l'écran
            appendCorrespondances(stationIcon, correspondances, 20);

            // Enfin, on ajoute la petite icone de station avec tout ses attributs à l'écran
            this.twigElements.gameArea.appendChild(stationIcon);
        })
    }
}

  // Une partie est créée dès qu'on arrive sur la page (direct)
  // Ici, on ajoute la fonctionnalité sauvegarder au bouton de la page Game
document.addEventListener('DOMContentLoaded', () => {
    const gameInstance = new MetroGame();

    const saveQuitBtn = document.getElementById('saveAndQuitBtn');
    const customConfirm = document.getElementById('customConfirm');
    const confirmYes = document.getElementById('confirmYesBtn');
    const confirmNo = document.getElementById('confirmNoBtn');

    if (saveQuitBtn && customConfirm && confirmYes && confirmNo) {
        saveQuitBtn.addEventListener('click', () => {
            gameInstance.state.finalTime = (Date.now() - gameInstance.state.startTime) / 1000;
            customConfirm.classList.remove('hidden');
        });

        confirmYes.addEventListener('click', () => {
            customConfirm.classList.add('hidden');
            gameInstance.endGame(true);
        });

        confirmNo.addEventListener('click', () => {
            customConfirm.classList.add('hidden');
        });
    }
});

