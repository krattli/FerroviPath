<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250325140957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute les lignes 1 à 4 du métro parisien avec leurs stations respectives';
    }

    public function up(Schema $schema): void
    {
        // Ajout des lignes
        $lines = [
            ['id' => 3, 'name' => 'Ligne 1', 'color' => '#f7d046', 'symbol' => '1'],
            ['id' => 4, 'name' => 'Ligne 2', 'color' => '#3570b4', 'symbol' => '2'],
            ['id' => 5, 'name' => 'Ligne 3', 'color' => '#98a642', 'symbol' => '3'],
            ['id' => 6, 'name' => 'Ligne 4', 'color' => '#b45092', 'symbol' => '4'],
        ];

        foreach ($lines as $line) {
            $this->addSql("
                INSERT INTO line (idLine, name_line, color, symbol, created_at)
                VALUES (:id, :name, :color, :symbol, NOW())
            ", [
                'id' => $line['id'],
                'name' => $line['name'],
                'color' => $line['color'],
                'symbol' => $line['symbol'],
            ]);
        }

        // Ajout des stations pour chaque ligne
        $stations = [
            3 => [
                'La Défense - Grande Arche',
                'Esplanade de la Défense',
                'Pont de Neuilly',
                'Les Sablons',
                'Porte Maillot',
                'Argentine',
                'Charles de Gaulle — Étoile',
                'George V',
                'Franklin D. Roosevelt',
                'Champs-Élysées — Clemenceau',
                'Concorde',
                'Tuileries',
                'Palais Royal - Musée du Louvre',
                'Louvre — Rivoli',
                'Châtelet',
                'Hôtel de Ville',
                'Saint-Paul',
                'Bastille',
                'Gare de Lyon',
                'Reuilly — Diderot',
                'Nation',
                'Porte de Vincennes',
                'Saint-Mandé',
                'Bérault',
                'Château de Vincennes',
            ],
            4 => [
                'Porte Dauphine',
                'Victor Hugo',
                'Charles de Gaulle — Étoile',
                'Ternes',
                'Courcelles',
                'Monceau',
                'Villiers',
                'Rome',
                'Place de Clichy',
                'Blanche',
                'Pigalle',
                'Anvers',
                'Barbès — Rochechouart',
                'La Chapelle',
                'Stalingrad',
                'Jaurès',
                'Colonel Fabien',
                'Belleville',
                'Couronnes',
                'Ménilmontant',
                'Père Lachaise',
                'Philippe Auguste',
                'Alexandre Dumas',
                'Avron',
                'Nation',
            ],
            5 => [
                'Pont de Levallois — Bécon',
                'Anatole France',
                'Louise Michel',
                'Porte de Champerret',
                'Pereire',
                'Wagram',
                'Malesherbes',
                'Villiers',
                'Europe',
                'Saint-Lazare',
                'Havre — Caumartin',
                'Opéra',
                'Quatre-Septembre',
                'Bourse',
                'Sentier',
                'Réaumur — Sébastopol',
                'Arts et Métiers',
                'Temple',
                'République',
                'Parmentier',
                'Rue Saint-Maur',
                'Père Lachaise',
                'Gambetta',
                'Porte de Bagnolet',
                'Gallieni',
            ],
            6 => [
                'Porte de Clignancourt',
                'Simplon',
                'Marcadet — Poissonniers',
                'Château Rouge',
                'Barbès — Rochechouart',
                'Gare du Nord',
                'Gare de l\'Est',
                'Château d\'Eau',
                'Strasbourg — Saint-Denis',
                'Réaumur — Sébastopol',
                'Étienne Marcel',
                'Les Halles',
                'Châtelet',
                'Cité',
                'Saint-Michel',
                'Odéon',
                'Saint-Germain-des-Prés',
                'Saint-Sulpice',
                'Saint-Placide',
                'Montparnasse — Bienvenüe',
                'Vavin',
                'Raspail',
                'Denfert-Rochereau',
                'Mouton-Duvernet',
                'Alésia',
                'Porte d\'Orléans',
                'Mairie de Montrouge',
            ],
        ];

        foreach ($stations as $lineId => $stationList) {
            foreach ($stationList as $stationName) {
                $this->addSql("
                    INSERT INTO station (name_station, axis_x, axis_y, created_at, id_line)
                    VALUES (:name, :axis_x, :axis_y, NOW(), :id_line)
                ", [
                    'name' => $stationName,
                    'axis_x' => 0.0,
                    'axis_y' => 0.0,
                    'id_line' => $lineId,
                ]);
            }
        }
    }

    public function down(Schema $schema): void
    {
        // Suppression des stations
        $this->addSql("DELETE FROM station WHERE id_line IN (1, 2, 3, 4)");

        // Suppression des lignes
        $this->addSql("DELETE FROM line WHERE idLine IN (1, 2, 3, 4)");
    }

}
