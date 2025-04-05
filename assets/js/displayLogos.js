
/*
* Le but de ce fichier js est de s'occuper de tout ce qui est relatif aux symboles de chaque lignes de métro
* L'apparence, la couleur et d'autres fonctionnalités, à chaque fois c'est à ce fichier qu'on est censé demander
* Du coup il va falloir migrer toutes les choses qu'on à déjà fait (y compris du code qu'on a mis dans du css ou du twig)
* Et absolument tout centraliser ici. C'est pas du gâteau
* */

console.log("✅ displayLogo chargé ! (écrit depuis assets/js/displayLogo.js")

/**
 * Crée un élément HTML représentant un logo de ligne de métro.
 * @param {string} color - Couleur de fond du logo (ex: "#ff0000").
 * @param {string} symbol - Symbole affiché à l'intérieur (ex: "A" pour rer A, "12" pour ligne 12).
 * @param {number} [size=50] - Taille en pixels (largeur/hauteur).
 * @returns {HTMLElement} - L'élément HTML du logo.
 */
export function createMetroLineLogo(color, symbol, size = 50) {
    const container = document.createElement('div');

    Object.assign(container.style, {
        //restera ici
        width: `${size}px`,
        height: `${size}px`,
        backgroundColor: color,
        fontSize: `${Math.round(size * 0.5)}px`,
        color: 'white',
        //sera externalisé dans la bdd
        borderRadius: '50%',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        fontFamily: 'Parisine, sans-serif',
        fontWeight: 'bold',
        cursor: 'pointer',
        transition: 'all 0.3s ease',
        userSelect: 'none',
        textAlign: 'center',
        boxSizing: 'border-box',
    });
    container.innerText = symbol;

    //pour qu'il soit reconnu par d'autres fonctionnalités qui ajouterons ou modiefirons le style de notre symbole
    container.classList.add('line-Symbol');

    return container;
}

/**
 * Renvoie une nuance de couleur différente de celle envoyée.
 * Le but est qu'elle fasse un petit contraste avec la couleur passée en paramètre
 * @param {string} color - Couleur dont on veux avoir une nuance voisine (ex: "#ff0000").
 * @param {number} percent - Pourcentage de différence qu'on veux avec l'ancienne couleur
 * @returns {string} - La nouvelle nuance de couleur
 */
export function adjustColor(color, percent) {
    color = color.replace('#', '');
    color = parseCouleur(color);
    const isDark = isDarkColor(color);
    const targetLuminanceChange = percent / 100 * 255;

    const originalLuminance = getLuminance(color);
    const targetLuminance = isDark ? originalLuminance + targetLuminanceChange : originalLuminance - targetLuminanceChange;

    // L'objectif de tout ça est que les nuances de couleurs paraissent avec la même quantité de
    const ratio = targetLuminance / originalLuminance;

    color.r = Math.min(255, Math.max(0, Math.floor(color.r * ratio)));
    color.g = Math.min(255, Math.max(0, Math.floor(color.g * ratio)));
    color.b = Math.min(255, Math.max(0, Math.floor(color.b * ratio)));

    color.r = toHex(color.r);
    color.g = toHex(color.g);
    color.b = toHex(color.b);

    return `#${color.r}${color.g}${color.b}`;
}

function parseCouleur(hex) {
    const bigint = parseInt(hex, 16);
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

function isDarkColor(color) {
    return getLuminance(color) < 128;
}

function getLuminance(color) {
    // formule de luminance relative, utilisée, car notre oeuil a des cones de visons spéciaux et savoir si une couleur est sombre ou clair n'est pas trivial
    return 0.299 * color.r + 0.587 * color.g + 0.114 * color.b;
}
