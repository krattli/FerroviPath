/*
* On va mettre ici des méthodes js inclassables
* utiles dans des contextes mais qui prennet un peu de place alors qu'on a pas vraiment besoin de voir ce qu'elles font exatement
* */


/**
 * Renvoie une nuance de couleur différente de celle envoyée.
 * Le but est qu'elle fasse un petit contraste avec la couleur passée en paramètre
 * @param {string} color - Couleur dont on veux avoir une nuance voisine (ex: "#ff0000").
 * @param {number} percent - Pourcentage de différence qu'on veux avec l'ancienne couleur
 * @returns {string} - La nouvelle nuance de couleur
 */
export function adjustColor(color, percent) {
    const ratio = getRatioLuminance(color,percent);
    color = parseCouleur(color);

    color.r = Math.min(255, Math.max(0, Math.floor(color.r * ratio)));
    color.g = Math.min(255, Math.max(0, Math.floor(color.g * ratio)));
    color.b = Math.min(255, Math.max(0, Math.floor(color.b * ratio)));

    color.r = toHex(color.r);
    color.g = toHex(color.g);
    color.b = toHex(color.b);

    return `#${color.r}${color.g}${color.b}`;
}

export function isDarkColor(color) {
    return getLuminance(color) < 132;
}

/**
 * Celle ci est plutot triviale
 * Fonction uniquement utilisée dans la classe metroGame lors de la victoire
 * Le code est juste externalisé, la classe est trop longue sinon
 * **/
export function showVictoryPopup() {
    const overlay = document.createElement('div');
    overlay.className = 'popup-overlay';

    const popupContainer = document.createElement('div');
    popupContainer.className = 'popup-container';

    const popupContent = document.createElement('div');
    popupContent.className = 'popup-content';

    const message = document.createElement('p');
    message.textContent = 'Félicitations ! Vous avez complété la ligne !';

    const homeButton = document.createElement('button');
    homeButton.textContent = 'Retour à l\'accueil';
    homeButton.className = 'popup-button';

    // Ajouter l'événement pour rediriger vers l'accueil
    homeButton.addEventListener('click', () => {
        console.log('Button clicked, saving game data...');
        window.location.href = '/';
    });

    popupContent.appendChild(message);
    popupContent.appendChild(homeButton);
    popupContainer.appendChild(popupContent);

    document.body.appendChild(overlay);
    document.body.appendChild(popupContainer); // Ajouter le popup

    setTimeout(() => {
        overlay.style.display = 'block';
        popupContainer.style.transform = 'translateX(-50%) translateY(0)';
        popupContainer.style.width = '80%';
        popupContainer.style.borderRadius = '30px';
    }, 50);
}

/**
 * celle ci est déjà un peu plus modulaire que la précédente
 * On utilise la classe feedBack de bootStrap pour faire des petits popup personnalisés
 * **/
export function showFeedback(text, type) {
    const feedback = document.createElement('div');
    feedback.className = `feedback ${type}`;
    feedback.textContent = text;
    document.body.appendChild(feedback);
    setTimeout(() => feedback.remove(), 2000);
}

// Calcul de l'espace que prendra une barre de ligne de métro en fonction de l'espace disponible
// La méthode gagnerait à être simplifiée
// Mais on veut comme effet que les stations apparaissent en gros au début puis plus il y en as, plus elles remplissent l'espace optimalement
export function computeSpacing(availableWidth, discoveredCount) {
    if (discoveredCount < 2) return 0;

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

function parseCouleur(color) {
    color = color.replace('#', '');
    const bigint = parseInt(color, 16);
    return {
        // j'adore les opérations de décalage de bit même si on pouvais juste utiliser substring
        r: (bigint >> 16) & 255,
        g: (bigint >> 8) & 255,
        b: bigint & 255
    };
}

function toHex(value) {
    const hex = value.toString(16);
    return hex.length === 1 ? '0' + hex : hex;
}

function getLuminance(color) {
    color = parseCouleur(color);
    // formule de luminance relative, utilisée, car notre oeuil a des cones de visons spéciaux et savoir si une couleur est sombre ou clair n'est pas trivial
    // bien sur ces trois chiffres sont minutieusement choisis pour que le résultat de nos calculs correspondent au rendu réel des couleurs des logos de ligne sinon ça serait pas drôle
    return 0.27 * color.r + 0.52 * color.g + 0.23 * color.b;
}

function getRatioLuminance(color, percent) {
    const isDark = isDarkColor(color);
    const targetLuminanceChange = percent / 100 * 255;

    const originalLuminance = getLuminance(color);
    const targetLuminance = isDark ? originalLuminance + targetLuminanceChange : originalLuminance - targetLuminanceChange;

    // L'objectif de tout ça est que les nuances de couleurs paraissent avec la même quantité de différence de luminance
    return targetLuminance / originalLuminance;
}

/**
 * C'est la fonction qui va donner les positions à l'écran en pixel de toutes les stations
 * Permet un affichage optimal avec des correspondances qui s'embrouillent pas les unes dans les autres
 * **/
export function getPositions(sortedDiscovered, correspondances, widthWereGonnaUse, size) {

    const spacing = computeAdjustedSpacing(sortedDiscovered, correspondances, widthWereGonnaUse, size);
    let positions = [];

    let totalStationWidth = 0;
    for (let i = 0; i < spacing.length - 1; i++) {
        totalStationWidth += spacing[i];
    }

    // La première station sera placée un peu à droite du bord quand même
    let accumulatedSpacing = (widthWereGonnaUse - totalStationWidth) / 2

    for (let i = 0; i < spacing.length ; i++) {
        positions[i] = accumulatedSpacing;
        accumulatedSpacing += spacing[i];
    }
    console.log("positions clone -->");
    console.log(positions);
    return positions;
}
function computeAdjustedSpacing(sortedDiscoveredStations, correspondances, availableWidth, size) {

    const primarySpacing = computeSpacing(availableWidth, sortedDiscoveredStations.length);
    let newAvailableWidth = availableWidth;
    let nbStationsToKeepNormalSpacing = sortedDiscoveredStations.length;

    let minSizeRequired = [];
    sortedDiscoveredStations.forEach((station, i) => {
        const nbCorr = correspondances.get(station).length;
        minSizeRequired[i] = minSizerequired(nbCorr, size);
        if (minSizeRequired[i] > primarySpacing) {
            newAvailableWidth -= minSizeRequired[i];
            nbStationsToKeepNormalSpacing -= 1;
        }
    })
    const newSpacing = computeSpacing(newAvailableWidth, nbStationsToKeepNormalSpacing);

    minSizeRequired.forEach((value, index) => {
        minSizeRequired[index] = Math.max(value, newSpacing)
    })
    return minSizeRequired;
}

// Fonction devenue innutile mais on la conserve au cas ou la nouvelle méthode getPosition a des bugs qu'on a pas remarqué
function oldGetPositions(widthWereGonnaUse, sortedDiscovered) {

    let positions = [];
    const count = sortedDiscovered.length;

    // Calcul de l'espacement dynamique entre les stations avec la fonction computeSpacing
    const spacing = computeSpacing(widthWereGonnaUse, count);
    // Calcul de la largeur totale occupée par le groupe de stations (pour la barre de ligne)
    const totalStationsWidth = spacing * (count - 1);
    // Calcul d'un décalage pour centrer le groupe dans la game-area
    const leftOffset = (widthWereGonnaUse - totalStationsWidth) / 2;
    positions = sortedDiscovered.map((_, index) => leftOffset + index * spacing);
    console.log("positions normal -->");
    console.log(positions);
    return positions;
}

/**
 * Petite fonction qui donne l'espace que devra prendre sur sa droite une station de métro avec n correspondances
 * c'est la même pour n=4 et n=2 car quand n=4, on réarrange verticalement les stations
 * @param nbCorrespondances - le nombre de correspondance de la station
 * @param size - l'étalon de taille d'affichage des stations en pixel
 * @param {boolean} hasEmptyNextStation - permet à ce que si la station suivante n'a pas de correspondance, on prenne un peu plus de place quand même
 * **/
function minSizerequired(nbCorrespondances, size, hasEmptyNextStation = false) {
    let sizeTaken = 0;
    if (nbCorrespondances === 0) {
        return sizeTaken;
    }
    else if (nbCorrespondances === 4) {
        sizeTaken += minSizerequired(2, size)
    }
    else {
        sizeTaken += (size * 1.3) + nbCorrespondances * size;
    }
    if (hasEmptyNextStation) {sizeTaken -= size * 0.7}
    return sizeTaken;
}