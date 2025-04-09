/*
* On va mettre ici des méthodes js inclassables
* utiles dans des contextes mais qui prennet un peu de place alors qu'on a pas vraiment besoin de voir ce qu'elles font exatement
* */

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

export function isDarkColor(color) {
    return getLuminance(color) < 132;
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