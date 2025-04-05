
/*
* Le but de ce fichier js est de s'occuper de tout ce qui est relatif aux symboles de chaque lignes de métro
* L'apparence, la couleur et d'autres fonctionnalités, à chaque fois c'est à ce fichier qu'on est censé demander
* Du coup il va falloir migrer toutes les choses qu'on à déjà fait (y compris du code qu'on a mis dans du css ou du twig)
* Et absolument tout centraliser ici. C'est pas du gâteau
* */

console.log("✅ displayLogo chargé ! (écrit depuis assets/js/displayLogo.js")

export function darkenColor(color, percent) {
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

function parseCouleur(hex) {
    hex = hex.replace('#', '');

    if (hex.length === 3) {
        hex = hex.split('').map(c => c + c).join('');
    }

    const r = parseInt(hex.substring(0, 2), 16);
    const g = parseInt(hex.substring(2, 4), 16);
    const b = parseInt(hex.substring(4, 6), 16);

    return { r, g, b };
}



export function isADarkColor(couleur) {
    couleur = couleur.replace('#','')

    return true;
}