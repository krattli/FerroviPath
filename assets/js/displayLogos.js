
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
export function createIconeTypeTransport(color, size, symbol) {
    const container = document.createElement('div');
    const textColor = isDarkColor(color) ? 'white' : 'black';

    Object.assign(container.style, {
        //restera ici
        width: `${size}px`,
        height: `${size}px`,
        backgroundColor: color,
        fontSize: `${size * 0.7}px`,
        color: textColor,
        //sera externalisé dans la bdd
        borderRadius: '50%',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        fontFamily: 'Parisine, sans-serif',
        fontWeight: 'bold',
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

export function createIconeStation(color, size, textContent, isTerminus = false, hasCorrespondances = false) {
    const container = document.createElement('div');
    const iconStation = document.createElement('div');
    const label = document.createElement('div');

    Object.assign(container.style, {
        position: 'absolute',
    });

    Object.assign(iconStation.style, {
        position: 'absolute',
        top: '50%',
        transform: 'translate(-50%, -50%)',
        width: `${size * 0.8}px`,
        height: `${size * 0.8}px`,
        borderRadius: '50%',
        backgroundColor: isTerminus ? 'white' : color,
        zIndex: 1,
    });

    if (hasCorrespondances) {
        iconStation.style.border = `${size * 0.1}px solid black`;
        iconStation.style.backgroundColor = 'white';
    }

    if (isTerminus) {
        iconStation.style.border = `${size * 0.15}px solid black`;
        iconStation.style.width = `${size}px`;
        iconStation.style.height = `${size}px`;

        const innerPoint = document.createElement('div');
        Object.assign(innerPoint.style, {
            position: 'absolute',
            top: '50%',
            left: '50%',
            transform: 'translate(-50%, -50%)',
            width: `${size * 0.40}px`,
            height: `${size * 0.40}px`,
            borderRadius: '50%',
            backgroundColor: color,
            zIndex: 2,
        });
        iconStation.appendChild(innerPoint);
    }

    Object.assign(label.style, {
        position: 'absolute',
        top: `calc(50% - ${size * 1.45}px)`,
        left: '50%',
        transformOrigin: 'bottom left',
        transform: `translateX(+${size * 0.15}px) translateY(+${size * 0.15}px) rotate(-45deg)`,
        fontSize: `${size * 0.65}px`,
        fontFamily: 'Parisine, sans-serif',
        fontWeight: 'bold',
        color: isTerminus ? 'white' : '#244798',
        whiteSpace: 'nowrap',
        zIndex: 1,
    });

    if (isTerminus) {
        label.style.padding = `0 ${size * 0.25}px`;
        label.style.backgroundColor = '#244798';
        label.style.transform = `translateX(+0%) translateY(-${size * 0.1}px) rotate(-45deg)`;
    }

    label.textContent = textContent;

    container.appendChild(label);
    container.appendChild(iconStation);

    return container;
}

export function appendCorrespondances(stationIcon, correspondances, size) {
    if (!correspondances || correspondances.length === 0) return;

    const verticalBar = document.createElement('div');
    Object.assign(verticalBar.style, {
        position: 'absolute',
        top: `calc(50% + ${size * 0.4}px)`,
        left: '50%',
        width: `${size * 0.1}px`,
        height: `${size * 0.7}px`,
        backgroundColor: '#244798',
        transform: `translateX(-50%) translateY(+${size * 0.1}px)`,
        zIndex: 0,
    });
    stationIcon.appendChild(verticalBar);

    const corrContainer = document.createElement('div');
    Object.assign(corrContainer.style, {
        position: 'absolute',
        top: `calc(50% + ${size * 1.3}px)`,
        left: '50%',
        transform: 'translateX(-50%)',
        display: 'inline-block',
        zIndex: 1,
    });

    const transportTypeLogo = createTransportTypeLogo('metro', size);
    corrContainer.appendChild(transportTypeLogo);

    const linesContainer = document.createElement('div');
    Object.assign(linesContainer.style, {
        position: 'absolute',
        top: '0',
        left: '100%',
        display: 'flex',
        marginLeft: `${size * 0.1}px`,
        flexDirection: 'row',
        alignItems: 'center',
        gap: `${size * 0.1}px`,
    });

    if (correspondances.length === 4) {
        append4correspondances(linesContainer, correspondances, size);
    } else {
        correspondances.forEach(corr => {
            const lineLogo = createIconeTypeTransport(corr.color, size, corr.symbol);
            linesContainer.appendChild(lineLogo);
        });
    }

    corrContainer.appendChild(linesContainer);
    stationIcon.appendChild(corrContainer);
}

export function createTransportTypeLogo(name, size) {
    const logo = document.createElement('div');
    if (name === 'metro') {
        Object.assign(logo.style, {
            width: `${size}px`,
            height: `${size}px`,
            fontSize: `${size * 0.65}px`,
            borderRadius: '50%',
            display: 'flex',
            border: `${size * 0.1}px solid #244798`,
            color: '#244798',
            alignItems: 'center',
            justifyContent: 'center',
            fontFamily: 'Parisine',
            fontsize: `${size * 2}px`,
            textAlign: 'center',
        });
        logo.textContent = 'M';
    }
    return logo;
}

function append4correspondances(linesContainer, correspondances, size) {
    linesContainer.style.flexDirection = "column";
    const topRow = document.createElement('div');
    Object.assign(topRow.style, {
        display: 'flex',
        flexDirection: 'row',
        gap: `${size * 0.1}px`,
    });

    for (let i = 0; i < 2; i++) {
        const lineLogo = createIconeTypeTransport(correspondances[i].color, size, correspondances[i].symbol);
        topRow.appendChild(lineLogo);
    }

    const bottomRow = document.createElement('div');
    Object.assign(bottomRow.style, {
        display: 'flex',
        flexDirection: 'row',
        gap: `${size * 0.1}px`,
    });

    for (let i = 2; i < 4; i++) {
        const lineLogo = createIconeTypeTransport(correspondances[i].color, size, correspondances[i].symbol);
        bottomRow.appendChild(lineLogo);
    }

    linesContainer.appendChild(topRow);
    linesContainer.appendChild(bottomRow);
}