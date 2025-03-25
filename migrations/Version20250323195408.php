<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250323195408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cette migration ajoute des données de test pour la base de donnée';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            INSERT INTO line (idLine, name_line, created_at)
            VALUES (1, 'Bakerloo Line', NOW())
        ");

        $stations = [
            ['name' => 'Harrow & Wealdstone', 'axisX' => 51.5925, 'axisY' => -0.3351],
            ['name' => 'Kenton', 'axisX' => 51.5816, 'axisY' => -0.3162],
            ['name' => 'South Kenton', 'axisX' => 51.5702, 'axisY' => -0.3081],
            ['name' => 'North Wembley', 'axisX' => 51.5621, 'axisY' => -0.3038],
            ['name' => 'Wembley Central', 'axisX' => 51.5524, 'axisY' => -0.2963],
            ['name' => 'Stonebridge Park', 'axisX' => 51.5441, 'axisY' => -0.2759],
            ['name' => 'Harlesden', 'axisX' => 51.5363, 'axisY' => -0.2575],
            ['name' => 'Willesden Junction', 'axisX' => 51.5318, 'axisY' => -0.2437],
            ['name' => 'Kensal Green', 'axisX' => 51.5306, 'axisY' => -0.2249],
            ['name' => 'Queen\'s Park', 'axisX' => 51.5341, 'axisY' => -0.2047],
            ['name' => 'Kilburn Park', 'axisX' => 51.5351, 'axisY' => -0.1939],
            ['name' => 'Maida Vale', 'axisX' => 51.53, 'axisY' => -0.1854],
            ['name' => 'Warwick Avenue', 'axisX' => 51.5233, 'axisY' => -0.1835],
            ['name' => 'Paddington', 'axisX' => 51.5154, 'axisY' => -0.1755],
            ['name' => 'Edgware Road', 'axisX' => 51.52, 'axisY' => -0.1679],
            ['name' => 'Marylebone', 'axisX' => 51.5225, 'axisY' => -0.1631],
            ['name' => 'Baker Street', 'axisX' => 51.5226, 'axisY' => -0.1571],
            ['name' => 'Regent\'s Park', 'axisX' => 51.5234, 'axisY' => -0.1466],
            ['name' => 'Oxford Circus', 'axisX' => 51.515, 'axisY' => -0.1415],
            ['name' => 'Piccadilly Circus', 'axisX' => 51.5098, 'axisY' => -0.1342],
            ['name' => 'Charing Cross', 'axisX' => 51.5073, 'axisY' => -0.1227],
            ['name' => 'Embankment', 'axisX' => 51.5074, 'axisY' => -0.1223],
            ['name' => 'Waterloo', 'axisX' => 51.5032, 'axisY' => -0.1133],
            ['name' => 'Lambeth North', 'axisX' => 51.4991, 'axisY' => -0.1121],
            ['name' => 'Elephant & Castle', 'axisX' => 51.4943, 'axisY' => -0.1001],
        ];

        foreach ($stations as $station) {
            $this->addSql("
                INSERT INTO station (name_station, axis_x, axis_y, created_at, id_line)
                VALUES (:name, :axisX, :axisY, NOW(), 1)
            ", [
                'name' => $station['name'],
                'axisX' => $station['axisX'],
                'axisY' => $station['axisY'],
            ]);
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM station WHERE id_line = 1");
        $this->addSql("DELETE FROM line WHERE idLine = 1");
    }
}
