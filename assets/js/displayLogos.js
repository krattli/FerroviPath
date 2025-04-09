
/*
* Le but de ce fichier js est de s'occuper de tout ce qui est relatif aux symboles de chaque lignes de métro
* L'apparence, la couleur et d'autres fonctionnalités, à chaque fois c'est à ce fichier qu'on est censé demander
* Du coup il va falloir migrer toutes les choses qu'on à déjà fait (y compris du code qu'on a mis dans du css ou du twig)
* Et absolument tout centraliser ici. C'est pas du gâteau
* */

import {isDarkColor} from "utilities.js";

console.log("✅ displayLogo chargé ! (écrit depuis assets/js/displayLogo.js")

/**
 * Crée un élément HTML représentant un logo de ligne de métro.
 * @param {string} color - Couleur de fond du logo (ex: "#ff0000").
 * @param {string} symbol - Symbole affiché à l'intérieur (ex: "A" pour rer A, "12" pour ligne 12).
 * @param {number} [size=50] - Taille en pixels (largeur/hauteur).
 * @returns {HTMLElement} - L'élément HTML du logo.
 */
export function createIconeTypeTransport(color, size = 50, symbol) {
    const container = document.createElement('div');
    const textColor = isDarkColor(color) ? 'white' : 'black';

    Object.assign(container.style, {
        //restera ici
        width: `${size}px`,
        height: `${size}px`,
        backgroundColor: color,
        fontSize: `${Math.round(size * 0.5)}px`,
        color: textColor,
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

export function createIconeStation(color, size = 16, textContent, isTerminus = false, hasCorrespondances = false) {
    const container = document.createElement('div');
    const iconStation = document.createElement('div');
    const label = document.createElement('div');

    Object.assign(container.style, {
        position: 'absolute',
//        zIndex: 1,
    });

    Object.assign(iconStation.style, {
        position: 'absolute',
        top: '50%',
        transform: 'translate(-50%, -50%)',
        width: `${size}px`,
        height: `${size}px`,
        borderRadius: '50%',
        backgroundColor: isTerminus ? 'white' : color,
        zIndex: 1,
    });

    if (hasCorrespondances) {
        iconStation.style.border = '2px solid black';
        iconStation.style.backgroundColor = 'white';
    }

    if (isTerminus) {
        iconStation.style.border = '2px solid black';
        iconStation.style.width = `${size + 4}px`;
        iconStation.style.height = `${size + 4}px`;

        const innerPoint = document.createElement('div');
        Object.assign(innerPoint.style, {
            position: 'absolute',
            top: '50%',
            left: '50%',
            transform: 'translate(-50%, -50%)',
            width: `${size - 6}px`,
            height: `${size - 6}px`,
            borderRadius: '50%',
            backgroundColor: color,
            zIndex: 2,
        });
        iconStation.appendChild(innerPoint);
    }

    Object.assign(label.style, {
        position: 'absolute',
        top: 'calc(50% - 30px)',
        left: '50%',
        transformOrigin: 'bottom left',
        transform: 'translateX(-2px) translateY(-2px) rotate(-45deg)',
        fontSize: '13px',
        fontFamily: 'Parisine, sans-serif',
        fontWeight: 'bold',
        color: isTerminus ? 'white' : '#244798',
        whiteSpace: 'nowrap',
        zIndex: 1,
    });

    if (isTerminus) {
        label.style.padding = '0 5px';
        label.style.backgroundColor = '#244798';
        //label.style.transform = 'translateX(+0%) translateY(-2px) rotate(-45deg)';
    }

    label.textContent = textContent;

    container.appendChild(iconStation);
    container.appendChild(label);

    return container;
}

export function appendCorrespondances(stationIcon, correspondances) {
    if (!correspondances || correspondances.length === 0) return;
    const verticalBar = document.createElement('div');
    Object.assign(verticalBar.style, {
        position: 'absolute',
        top: 'calc(50% + 8px)',
        left: '50%',
        width: '2px',
        height: '18px',
        backgroundColor: '#244798',
        transform: 'translateX(-50%)',
        zIndex: 0,
    });

    // Conteneur flex pour les icônes
    const corrContainer = document.createElement('div');
    Object.assign(corrContainer.style, {
        position: 'absolute',
        top: 'calc(50% + 26px)',
        left: '50%',
        display: 'flex',
        gap: '4px',
        transform: 'translateX(-50%)',
        zIndex: 1,
    });

    correspondances.forEach(corr => {
        const logo = createIconeTypeTransport(corr.color, 20, corr.symbol);
        corrContainer.appendChild(logo);
    });

    stationIcon.appendChild(verticalBar);
    stationIcon.appendChild(corrContainer);
}