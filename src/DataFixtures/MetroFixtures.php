<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Line;
use App\Entity\Station;

class MetroFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $lines = [
            ['id_line' => 1, 'nameLine' => 'Ligne 1', 'color' => '#FFCE00', 'symbol' => '1',
            'stations' =>[['La Défense - Grande Arche', 48.8925, 2.2369],
                        ['Esplanade de la Défense', 48.8887, 2.2504],
                        ['Pont de Neuilly', 48.8841, 2.2614],
                        ['Les Sablons', 48.8798, 2.2694],
                        [ 'Porte Maillot', 48.8763, 2.2820],
                        ['Argentine', 48.8753, 2.2901],
                        [ 'Charles de Gaulle - Étoile', 48.8738, 2.2950],
                        ['George V', 48.8722, 2.3015],
                        ['Franklin D. Roosevelt', 48.8697, 2.3097],
                        ['Champs-Élysées - Clemenceau', 48.8665, 2.3161],
                        ['Concorde', 48.8656, 2.3213],
                        ['Tuileries', 48.8635, 2.3283],
                        ['Palais Royal - Musée du Louvre', 48.8620, 2.3364],
                        ['Louvre — Rivoli', 48.8610, 2.3416],
                        ['Châtelet', 48.8586, 2.3471],
                        ['Hôtel de Ville', 48.8574, 2.3514],
                        ['Saint-Paul', 48.8552, 2.3599],
                        ['Bastille', 48.8530, 2.3691],
                        ['Gare de Lyon', 48.8459, 2.3730],
                        ['Reuilly - Diderot', 48.8468, 2.3860],
                        ['Nation', 48.8485, 2.3953],
                        ['Porte de Vincennes', 48.8462, 2.4076],
                        ['Saint-Mandé', 48.8444, 2.4153],
                        ['Bérault', 48.8453, 2.4231],
                        ['Château de Vincennes', 48.8442, 2.4346]]],
        
    ['id_line' => 2, 'nameLine' => 'Ligne 2', 'color' => '#0064B0', 'symbol' => '2',
        'stations' => [
            ['Porte Dauphine', 48.8713, 2.2756],
            ['Victor Hugo', 48.8716, 2.2873],
            ['Charles de Gaulle - Étoile', 48.8738, 2.295],
            ['Ternes', 48.8785, 2.3011],
            ['Courcelles', 48.8797, 2.3074],
            ['Monceau', 48.8809, 2.3125],
            ['Villiers', 48.8821, 2.3189],
            ['Rome', 48.8827, 2.3263],
            ['Place de Clichy', 48.8823, 2.3294],
            ['Blanche', 48.8833, 2.3333],
            ['Pigalle', 48.8826, 2.3372],
            ['Anvers', 48.8821, 2.3444],
            ['Barbès - Rochechouart', 48.882, 2.3499],
            ['La Chapelle', 48.8842, 2.3607],
            ['Stalingrad', 48.8846, 2.3701],
            ['Jaurès', 48.8829, 2.3765],
            ['Colonel Fabien', 48.8799, 2.3703],
            ['Belleville', 48.8722, 2.3807],
            ['Couronnes', 48.8703, 2.3844],
            ['Ménilmontant', 48.8684, 2.3891],
            ['Père Lachaise', 48.8637, 2.3871],
            ['Philippe Auguste', 48.8618, 2.3923],
            ['Alexandre Dumas', 48.8594, 2.397],
            ['Avron', 48.8573, 2.4011],
            ['Nation', 48.8483, 2.3958]
        ]
    ],
    ['id_line' => 3, 'nameLine' => 'Ligne 3', 'color' => '#9F9825', 'symbol' => '3',
        'stations' => [
            ['Pont de Levallois - Bécon', 48.8965, 2.2785],
            ['Anatole France', 48.8925, 2.2896],
            ['Louise Michel', 48.8892, 2.2967],
            ['Porte de Champerret', 48.8855, 2.3009],
            ['Pereire', 48.8842, 2.3073],
            ['Wagram', 48.8832, 2.3128],
            ['Malesherbes', 48.8822, 2.3185],
            ['Villiers', 48.8807, 2.3244],
            ['Europe', 48.8777, 2.3269],
            ['Saint-Lazare', 48.8754, 2.3281],
            ['Havre - Caumartin', 48.8726, 2.3305],
            ['Opéra', 48.8719, 2.3325],
            ['Quatre-Septembre', 48.8697, 2.3366],
            ['Bourse', 48.8686, 2.3407],
            ['Sentier', 48.8674, 2.3463],
            ['Réaumur - Sébastopol', 48.8661, 2.3522],
            ['Arts et Métiers', 48.8653, 2.3567],
            ['Temple', 48.8638, 2.3623],
            ['République', 48.8668, 2.3634],
            ['Parmentier', 48.8641, 2.3700],
            ['Rue Saint-Maur', 48.8631, 2.3770],
            ['Père Lachaise', 48.8613, 2.3875],
            ['Gambetta', 48.8650, 2.3987],
            ['Porte de Bagnolet', 48.8642, 2.4075],
            ['Gallieni', 48.8659, 2.4156]
        ]
    ],

    ['id_line' => 4, 'nameLine' => 'Ligne 4', 'color' => '#C04191', 'symbol' => '4',
    'stations' => [
        ['Porte de Clignancourt', 48.8995, 2.3445],
        ['Simplon', 48.8946, 2.3498],
        ['Marcadet - Poissonniers', 48.8915, 2.3498],
        ['Château Rouge', 48.8886, 2.3495],
        ['Barbès - Rochechouart', 48.882, 2.3499],
        ['Gare du Nord', 48.8809, 2.3553],
        ['Gare de l\'Est', 48.8755, 2.3572],
        ['Château d\'Eau', 48.8722, 2.3556],
        ['Strasbourg - Saint-Denis', 48.8695, 2.3541],
        ['Réaumur - Sébastopol', 48.8661, 2.3522],
        ['Étienne Marcel', 48.8635, 2.3495],
        ['Les Halles', 48.8625, 2.3464],
        ['Châtelet', 48.858, 2.347],
        ['Cité', 48.8554, 2.3463],
        ['Saint-Michel', 48.8532, 2.3449],
        ['Odéon', 48.8522, 2.3418],
        ['Saint-Germain-des-Prés', 48.8542, 2.3332],
        ['Saint-Sulpice', 48.8511, 2.3325],
        ['Saint-Placide', 48.8483, 2.3324],
        ['Montparnasse - Bienvenüe', 48.8437, 2.3223],
        ['Vavin', 48.846, 2.3244],
        ['Raspail', 48.841, 2.3254],
        ['Denfert-Rochereau', 48.8339, 2.3325],
        ['Mouton-Duvernet', 48.8321, 2.3311],
        ['Alésia', 48.8301, 2.3265],
        ['Porte d\'Orléans', 48.8239, 2.3254],
        ['Mairie de Montrouge', 48.8239, 2.3244],
        ['Barbara', 48.8239, 2.3234],
        ['Bagneux Lucie Aubrac', 48.8239, 2.3234]
    ]],
    ['id_line' => 5, 'nameLine' => 'Ligne 5', 'color' => '#F28E42', 'symbol' => '5',
    'stations' => [ ['Bobigny - Pablo Picasso', 48.9097, 2.4396],
                    ['Bobigny - Pantin - Raymond Queneau', 48.8981, 2.4242],
                    ['Eglise de Pantin', 48.8919, 2.4129],
                    ['Hoche', 48.8881, 2.4016],
                    ['Porte de Pantin', 48.8899, 2.3936],
                    ['Ourcq', 48.8882, 2.3844],
                    ['Laumière', 48.8864, 2.3791],
                    ['Jaurès', 48.8827, 2.3707],
                    ['Stalingrad', 48.8837, 2.3681],
                    ['Gare du Nord', 48.8808, 2.3553],
                    ['Gare de l\'Est', 48.8763, 2.3582],
                    ['Jacques Bonsergent', 48.8707, 2.3634],
                    ['République', 48.8674, 2.3630],
                    ['Oberkampf', 48.8659, 2.3709],
                    ['Richard-Lenoir', 48.8617, 2.3728],
                    ['Bréguet - Sabin', 48.8579, 2.3751],
                    ['Bastille', 48.8536, 2.3692],
                    ['Quai de la Rapée', 48.8463, 2.3665],
                    ['Gare d\'Austerlitz', 48.8438, 2.3643],
                    ['Saint-Marcel', 48.8415, 2.3625],
                    ['Campo-Formio', 48.8394, 2.3576],
                    ['Place d\'Italie', 48.8322, 2.3550]]],
['id_line' => 6, 'nameLine' => 'Ligne 6', 'color' => '#83C491', 'symbol' => '6',
    'stations' => [ ['Charles de Gaulle - Etoile', 48.8738, 2.2950],
                    ['Kléber', 48.8718, 2.2930],
                    ['Boissière', 48.8685, 2.2891],
                    ['Trocadéro', 48.8638, 2.2871],
                    ['Passy', 48.8575, 2.2854],
                    ['Bir-Hakeim', 48.8553, 2.2891],
                    ['Dupleix', 48.8508, 2.2937],
                    ['La Motte-Picquet - Grenelle', 48.8471, 2.2986],
                    ['Cambronne', 48.8442, 2.3011],
                    ['Sèvres - Lecourbe', 48.8415, 2.3077],
                    ['Pasteur', 48.8395, 2.3129],
                    ['Montparnasse - Bienvenüe', 48.8431, 2.3237],
                    ['Edgar Quinet', 48.8413, 2.3271],
                    ['Raspail', 48.8383, 2.3301],
                    ['Denfert-Rochereau', 48.8339, 2.3322],
                    ['Saint-Jacques', 48.8311, 2.3339],
                    ['Glacière', 48.8281, 2.3347],
                    ['Corvisart', 48.8252, 2.3487],
                    ['Place d\'Italie', 48.8318, 2.3551],
                    ['Nationale', 48.8293, 2.3624],
                    ['Chevaleret', 48.8330, 2.3692],
                    ['Quai de la Gare', 48.8373, 2.3732],
                    ['Bercy', 48.8408, 2.3816],
                    ['Dugommier', 48.8357, 2.3863],
                    ['Daumesnil', 48.8342, 2.3952],
                    ['Bel-Air', 48.8362, 2.4011],
                    ['Picpus', 48.8375, 2.4051],
                    ['Nation', 48.8485, 2.3959]]],
[
    'id_line' => 7,
    'nameLine' => 'Ligne 7',
    'color' => '#F3A4BA',
    'symbol' => '7',
    'stations' => [
        ['La Courneuve - 8 Mai 1945', 48.9182, 2.4102],
        ['Fort d\'Aubervilliers', 48.9135, 2.4097],
        ['Aubervilliers - Pantin - Quatre Chemins', 48.9069, 2.4072],
        ['Porte de la Villette', 48.8985, 2.3846],
        ['Corentin Cariou', 48.8961, 2.3773],
        ['Crimée', 48.8916, 2.3763],
        ['Riquet', 48.8883, 2.3758],
        ['Stalingrad', 48.8837, 2.3681],
        ['Louis Blanc', 48.8824, 2.3661],
        ['Château-Landon', 48.8804, 2.3624],
        ['Gare de l\'Est', 48.8763, 2.3582],
        ['Poissonnière', 48.8782, 2.3485],
        ['Cadet', 48.8755, 2.3444],
        ['Le Peletier', 48.8733, 2.3414],
        ['Chaussée d\'Antin - La Fayette', 48.8725, 2.3390],
        ['Opéra', 48.8718, 2.3320],
        ['Pyramides', 48.8654, 2.3322],
        ['Palais Royal - Musée du Louvre', 48.8623, 2.3370],
        ['Pont Neuf', 48.8583, 2.3417],
        ['Châtelet', 48.8582, 2.3470],
        ['Pont Marie', 48.8555, 2.3593],
        ['Sully - Morland', 48.8523, 2.3639],
        ['Jussieu', 48.8452, 2.3561],
        ['Place Monge', 48.8436, 2.3511],
        ['Censier - Daubenton', 48.8413, 2.3475],
        ['Les Gobelins', 48.8369, 2.3482],
        ['Place d\'Italie', 48.8322, 2.3550],
        ['Tolbiac', 48.8271, 2.3552],
        ['Maison Blanche', 48.8236, 2.3584],
        ['Le Kremlin-Bicêtre', 48.8147, 2.3601],
        ['Villejuif - Léo Lagrange', 48.8074, 2.3644],
        ['Villejuif - Paul Vaillant-Couturier', 48.8014, 2.3679],
        ['Villejuif - Louis Aragon', 48.7932, 2.3709],
        ['Porte d\'Italie', 48.8196, 2.3622],
        ['Porte de Choisy', 48.8170, 2.3649],
        ['Porte d\'Ivry', 48.8150, 2.3667],
        ['Pierre et Marie Curie', 48.8107, 2.3698],
        ['Mairie d\'Ivry', 48.8061, 2.3702]
    ]
],
[
    'id_line' => 8,
    'nameLine' => 'Ligne 8',
    'color' => '#CEADD2',
    'symbol' => '8',
    'stations' => [
        ['Balard', 48.8364, 2.2785],
        ['Lourmel', 48.8389, 2.2835],
        ['Boucicaut', 48.8407, 2.2874],
        ['Félix Faure', 48.8423, 2.2912],
        ['Commerce', 48.8442, 2.2946],
        ['La Motte-Picquet - Grenelle', 48.8490, 2.2985],
        ['Ecole Militaire', 48.8551, 2.3072],
        ['La Tour-Maubourg', 48.8580, 2.3123],
        ['Invalides', 48.8621, 2.3165],
        ['Concorde', 48.8656, 2.3215],
        ['Madeleine', 48.8697, 2.3245],
        ['Opéra', 48.8724, 2.3312],
        ['Richelieu - Drouot', 48.8738, 2.3382],
        ['Grands Boulevards', 48.8723, 2.3437],
        ['Bonne-Nouvelle', 48.8706, 2.3489],
        ['Strasbourg - Saint-Denis', 48.8692, 2.3543],
        ['République', 48.8674, 2.3630],
        ['Filles du Calvaire', 48.8641, 2.3689],
        ['Saint-Sébastien - Froissart', 48.8619, 2.3724],
        ['Chemin Vert', 48.8597, 2.3762],
        ['Bastille', 48.8530, 2.3695],
        ['Ledru-Rollin', 48.8512, 2.3777],
        ['Faidherbe - Chaligny', 48.8491, 2.3832],
        ['Reuilly - Diderot', 48.8470, 2.3876],
        ['Montgallet', 48.8450, 2.3929],
        ['Daumesnil', 48.8418, 2.4005],
        ['Michel Bizot', 48.8392, 2.4075],
        ['Porte Dorée', 48.8371, 2.4114],
        ['Porte de Charenton', 48.8354, 2.4163],
        ['Liberté', 48.8285, 2.4189],
        ['Charenton - Ecoles', 48.8241, 2.4196],
        ['Ecole vétérinaire de Maisons-Alfort', 48.8198, 2.4187],
        ['Maisons-Alfort - Stade', 48.8144, 2.4193],
        ['Maisons-Alfort - Les Juilliottes', 48.8095, 2.4211],
        ['Créteil - L\'Echat', 48.8034, 2.4291],
        ['Créteil - Université', 48.7984, 2.4365],
        ['Créteil - Préfecture', 48.7912, 2.4452],
        ['Créteil - Pointe du Lac', 48.7876, 2.4603]
    ]
    ],

[
    'id_line' => 9,
    'nameLine' => 'Ligne 9',
    'color' => '#D5C900',
    'symbol' => '9',
    'stations' => [
        ['Pont de Sèvres', 48.8356, 2.2336],
        ['Billancourt', 48.8334, 2.2395],
        ['Marcel Sembat', 48.8330, 2.2432],
        ['Porte de Saint-Cloud', 48.8372, 2.2563],
        ['Exelmans', 48.8412, 2.2598],
        ['Michel-Ange - Molitor', 48.8454, 2.2627],
        ['Michel-Ange - Auteuil', 48.8473, 2.2658],
        ['Jasmin', 48.8503, 2.2691],
        ['Ranelagh', 48.8540, 2.2742],
        ['La Muette', 48.8562, 2.2763],
        ['Rue de la Pompe', 48.8621, 2.2784],
        ['Trocadéro', 48.8637, 2.2888],
        ['Iéna', 48.8654, 2.2950],
        ['Alma - Marceau', 48.8663, 2.3000],
        ['Franklin D. Roosevelt', 48.8681, 2.3084],
        ['Saint-Philippe du Roule', 48.8701, 2.3133],
        ['Miromesnil', 48.8724, 2.3185],
        ['Saint-Augustin', 48.8753, 2.3237],
        ['Havre - Caumartin', 48.8759, 2.3282],
        ['Chaussée d\'Antin - La Fayette', 48.8744, 2.3323],
        ['Richelieu - Drouot', 48.8728, 2.3376],
        ['Grands Boulevards', 48.8723, 2.3437],
        ['Bonne-Nouvelle', 48.8706, 2.3489],
        ['Strasbourg - Saint-Denis', 48.8692, 2.3543],
        ['République', 48.8674, 2.3630],
        ['Oberkampf', 48.8650, 2.3702],
        ['Saint-Ambroise', 48.8634, 2.3732],
        ['Voltaire', 48.8617, 2.3801],
        ['Charonne', 48.8596, 2.3865],
        ['Rue des Boulets', 48.8566, 2.3904],
        ['Nation', 48.8484, 2.3959],
        ['Buzenval', 48.8521, 2.4003],
        ['Maraîchers', 48.8546, 2.4064],
        ['Porte de Montreuil', 48.8572, 2.4127],
        ['Robespierre', 48.8578, 2.4186],
        ['Croix de Chavaux', 48.8591, 2.4263],
        ['Mairie de Montreuil', 48.8633, 2.4393]
    ]
    ],

    [
        'id_line' => 10,
        'nameLine' => 'Ligne 10',
        'color' => '#E3B32A',
        'symbol' => '10',
        'stations' => [
            ['Boulogne - Pont de Saint-Cloud', 48.8355, 2.2309],
            ['Boulogne - Jean Jaurès', 48.8352, 2.2397],
            ['Michel-Ange - Molitor', 48.8472, 2.2647],
            ['Chardon-Lagache', 48.8476, 2.2692],
            ['Mirabeau', 48.8485, 2.2733],
            ['Porte d\'Auteuil', 48.8461, 2.2644],
            ['Michel-Ange - Auteuil', 48.8473, 2.2658],
            ['Église d\'Auteuil', 48.8482, 2.2698],
            ['Javel - André Citroën', 48.8489, 2.2745],
            ['Charles Michels', 48.8476, 2.2849],
            ['Avenue Émile-Zola', 48.8474, 2.2905],
            ['La Motte-Picquet - Grenelle', 48.8494, 2.2986],
            ['Ségur', 48.8492, 2.3114],
            ['Duroc', 48.8467, 2.3191],
            ['Vaneau', 48.8472, 2.3255],
            ['Sèvres - Babylone', 48.8516, 2.3258],
            ['Mabillon', 48.8536, 2.3364],
            ['Odéon', 48.8546, 2.3387],
            ['Cluny - La Sorbonne', 48.8519, 2.3444],
            ['Maubert - Mutualité', 48.8506, 2.3473],
            ['Cardinal Lemoine', 48.8474, 2.3525],
            ['Jussieu', 48.8465, 2.3542],
            ['Gare d\'Austerlitz', 48.8442, 2.3651]
        ]
        ],
    
        [
            'id_line' => 11,
            'nameLine' => 'Ligne 11',
            'color' => '#8D5E2A',
            'symbol' => '11',
            'stations' => [
                ['Châtelet', 48.8582, 2.3470],
                ['Hôtel de Ville', 48.8575, 2.3510],
                ['Rambuteau', 48.8609, 2.3522],
                ['Arts et Métiers', 48.8651, 2.3548],
                ['République', 48.8673, 2.3630],
                ['Goncourt', 48.8693, 2.3705],
                ['Belleville', 48.8720, 2.3768],
                ['Pyrénées', 48.8755, 2.3821],
                ['Jourdain', 48.8778, 2.3876],
                ['Place des Fêtes', 48.8795, 2.3923],
                ['Télégraphe', 48.8806, 2.3986],
                ['Porte des Lilas', 48.8814, 2.4073],
                ['Mairie des Lilas', 48.8802, 2.4190],
                ['Serge Gainsbourg', 48.8814, 2.4275],
                ['Romainville - Carnot', 48.8831, 2.4406],
                ['Montreuil - Hôpital', 48.8783, 2.4544],
                ['La Dhuys', 48.8781, 2.4656],
                ['Coteaux Beauclair', 48.8822, 2.4672],
                ['Rosny-Bois-Perrier', 48.8825, 2.4808]
            ]
            ],
        
        
            [
                'id_line' => 12,
                'nameLine' => 'Ligne 12',
                'color' => '#00814F',
                'symbol' => '12',
                'stations' => [
                    ['Mairie d\'Aubervilliers', 48.9034, 2.3785],
                    ['Aimé Césaire', 48.8995, 2.3782],
                    ['Aubervilliers Front Populaire', 48.8999, 2.3857],
                    ['Porte de la Chapelle', 48.8919, 2.3742],
                    ['Marx Dormoy', 48.8877, 2.3653],
                    ['Marcadet - Poissonniers', 48.8856, 2.3581],
                    ['Jules Joffrin', 48.8846, 2.3431],
                    ['Lamarck - Caulaincourt', 48.8830, 2.3374],
                    ['Abbesses', 48.8842, 2.3383],
                    ['Pigalle', 48.8827, 2.3333],
                    ['Saint-Georges', 48.8792, 2.3346],
                    ['Notre-Dame-de-Lorette', 48.8763, 2.3419],
                    ['Trinité - d\'Estienne d\'Orves', 48.8752, 2.3433],
                    ['Saint-Lazare', 48.8745, 2.3266],
                    ['Madeleine', 48.8738, 2.3241],
                    ['Concorde', 48.8662, 2.3216],
                    ['Assemblée nationale', 48.8618, 2.3209],
                    ['Solférino', 48.8611, 2.3183],
                    ['Rue du Bac', 48.8578, 2.3169],
                    ['Sèvres - Babylone', 48.8547, 2.3142],
                    ['Rennes', 48.8485, 2.3144],
                    ['Notre-Dame-des-Champs', 48.8432, 2.3146],
                    ['Montparnasse - Bienvenüe', 48.8422, 2.3214],
                    ['Falguière', 48.8414, 2.3257],
                    ['Pasteur', 48.8404, 2.3275],
                    ['Volontaires', 48.8364, 2.3283],
                    ['Vaugirard', 48.8328, 2.3277],
                    ['Convention', 48.8296, 2.3273],
                    ['Porte de Versailles', 48.8262, 2.3009],
                    ['Corentin Celton', 48.8223, 2.2967],
                    ['Mairie d\'Issy', 48.8185, 2.2859]
                ]
                ],
            
                [
                    'id_line' => 13,
                    'nameLine' => 'Ligne 13',
                    'color' => '#98D4E2',
                    'symbol' => '13',
                    'stations' => [
                        ['Asnières - Gennevilliers - Les Courtilles', 48.9078, 2.3199],
                        ['Les Agnettes', 48.9088, 2.3319],
                        ['Gabriel Péri', 48.9099, 2.3385],
                        ['Mairie de Clichy', 48.8981, 2.3079],
                        ['Porte de Clichy', 48.8962, 2.3131],
                        ['Brochant', 48.8878, 2.3141],
                        ['Saint-Denis - Université', 48.9333, 2.3595],
                        ['Basilique de Saint-Denis', 48.9342, 2.3586],
                        ['Saint-Denis - Porte de Paris', 48.9301, 2.3604],
                        ['Carrefour Pleyel', 48.9217, 2.3476],
                        ['Mairie de Saint-Ouen', 48.8997, 2.3308],
                        ['Garibaldi', 48.8893, 2.3228],
                        ['Porte de Saint-Ouen', 48.8886, 2.3255],
                        ['Guy Môquet', 48.8875, 2.3263],
                        ['La Fourche', 48.8872, 2.3295],
                        ['Place de Clichy', 48.8842, 2.3318],
                        ['Liège', 48.8831, 2.3369],
                        ['Saint-Lazare', 48.8740, 2.3312],
                        ['Miromesnil', 48.8730, 2.3195],
                        ['Champs-Elysées - Clemenceau', 48.8694, 2.3069],
                        ['Invalides', 48.8600, 2.3121],
                        ['Varenne', 48.8567, 2.3180],
                        ['Saint-François-Xavier', 48.8483, 2.3125],
                        ['Duroc', 48.8431, 2.3187],
                        ['Montparnasse - Bienvenüe', 48.8439, 2.3202],
                        ['Gaîté', 48.8419, 2.3251],
                        ['Pernety', 48.8406, 2.3304],
                        ['Plaisance', 48.8367, 2.3328],
                        ['Porte de Vanves', 48.8320, 2.3360],
                        ['Malakoff - Plateau de Vanves', 48.8262, 2.3379],
                        ['Malakoff - Rue Etienne-Dolet', 48.8215, 2.3404],
                        ['Châtillon - Montrouge', 48.8160, 2.3450]
                    ]
                    ],
                
                    [
                        'id_line' => 14,
                        'nameLine' => 'Ligne 14',
                        'color' => '#662483',
                        'symbol' => '14',
                        'stations' => [
                            ['Saint-Denis-Pleyel', 48.9334, 2.3303],
                            ['Mairie de Saint-Ouen', 48.8949, 2.3235],
                            ['Saint-Ouen', 48.8934, 2.3322],
                            ['Porte de Clichy', 48.8957, 2.3232],
                            ['Pont Cardinet', 48.8898, 2.3188],
                            ['Saint Lazare', 48.8738, 2.3260],
                            ['Madeleine', 48.8706, 2.3287],
                            ['Pyramides', 48.8653, 2.3299],
                            ['Châtelet', 48.8596, 2.3452],
                            ['Gare de Lyon', 48.8442, 2.3741],
                            ['Bercy', 48.8346, 2.3730],
                            ['Cour Saint-Emilion', 48.8325, 2.3800],
                            ['Bibliothèque François Mitterrand', 48.8319, 2.3775],
                            ['Olympiades', 48.8186, 2.3653],
                            ['Maison Blanche', 48.8136, 2.3544],
                            ['Hôpital du Kremlin-Bicêtre', 48.8019, 2.3464],
                            ['Villejuif - Institut Gustave-Roussy', 48.7917, 2.3283],
                            ['Chevilly-Larue', 48.7839, 2.3150],
                            ['Porte de Thiais - Marché International', 48.7763, 2.3099],
                            ['Pont de Rungis', 48.7642, 2.2834],
                            ['Aéroport d\'Orly', 48.7264, 2.3797]
                        ]
                        ],
                    
                        [
                            'id_line' => 15,
                            'nameLine' => 'Ligne 7 bis',
                            'color' => '#83C491',
                            'symbol' => '7b',
                            'stations' => [
                                ['Louis Blanc', 48.8764, 2.3647],
                                ['Jaurès', 48.8763, 2.3749],
                                ['Bolivar', 48.8794, 2.3856],
                                ['Buttes Chaumont', 48.8837, 2.3898],
                                ['Botzaris', 48.8870, 2.3926],
                                ['Place des Fêtes', 48.8892, 2.3977],
                                ['Pré Saint-Gervais', 48.8917, 2.4029],
                                ['Danube', 48.8936, 2.4073]
                            ]
                        ],
                        [
                            'id_line' => 16,
                            'nameLine' => 'Ligne 3 bis',
                            'color' => '#98D4E2',
                            'symbol' => '3b',
                            'stations' => [
                                ['Porte des Lilas', 48.8686, 2.4125],
                                ['Saint-Fargeau', 48.8671, 2.4079],
                                ['Pelleport', 48.8678, 2.4027],
                                ['Gambetta', 48.8699, 2.3969]
                            ]
                        ]
                        
        ];

        foreach($lines as $line){
            $lineE = new Line();
                $lineE->setIdLine($line['id_line']);
                $lineE->setNameLine($line['nameLine']);
                $lineE->setColor($line['color']);
                $lineE->setSymbol($line['symbol']);
                $lineE->setCreatedAt(new \DateTimeImmutable());
                $manager->persist($lineE);
        
                foreach($line['stations'] as $stationData){
                    $station = new Station();
                    $station->setNameStation($stationData[0]);
                    $station->setAxisX((float)$stationData[1]);
                    $station->setAxisY((float)$stationData[2]);
                    $station->setLine($lineE);
                    $station->setCreatedAt(new \DateTimeImmutable());
        
                    $manager->persist($station);
                }
        }
        $manager->flush();
        $allStationsGroupedByNames = [];
        $stations = $manager->getRepository(Station::class)->findAll();
        foreach ($stations as $station) {
            $name = $station->getNameStation();
            if (!isset($allStationsGroupedByNames[$name])) {
                $allStationsGroupedByNames[$name] = [];
            }
            $allStationsGroupedByNames[$name][] = $station;
        }
        foreach ($allStationsGroupedByNames as $stationsWithSameName) {
            if (count($stationsWithSameName) > 1) {
                foreach ($stationsWithSameName as $stationA) {
                    foreach ($stationsWithSameName as $stationB) {
                        if ($stationA !== $stationB) {
                            $stationA->addCorrespondance($stationB);
                            $manager->persist($stationA);
                            $manager->persist($stationB);
                        }
                    }
                }
            }
        }
        $manager->flush();
    }
}
