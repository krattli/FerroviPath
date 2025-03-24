<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250324153157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cette migration ajoute les données de la ligne 3 bis du métro parisien et ses stations';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            INSERT INTO line (idLine, name_line, color, symbol, created_at)
            VALUES (2, 'Ligne 3 bis', '#9ad1dc', '3b', NOW())
        ");

        $stations = [
            ['name' => 'Gambetta', 'axisX' => 48.8650, 'axisY' => 2.3987],
            ['name' => 'Pelleport', 'axisX' => 48.8692, 'axisY' => 2.4013],
            ['name' => 'Saint-Fargeau', 'axisX' => 48.8718, 'axisY' => 2.4028],
            ['name' => 'Porte des Lilas', 'axisX' => 48.8757, 'axisY' => 2.4056],
        ];

        foreach ($stations as $station) {
            $this->addSql("
                INSERT INTO station (name_station, axis_x, axis_y, created_at, id_line)
                VALUES (:name, :axisX, :axisY, NOW(), 2)
            ", [
                'name' => $station['name'],
                'axisX' => $station['axisX'],
                'axisY' => $station['axisY'],
            ]);
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM station WHERE id_line = 2");
        $this->addSql("DELETE FROM line WHERE idLine = 2");
    }
}
