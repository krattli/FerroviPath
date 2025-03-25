<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250324111957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout des colonnes color et symbol à la table line et mise à jour des données pour Bakerloo Line';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE line ADD color VARCHAR(7) NOT NULL, ADD symbol VARCHAR(10) NOT NULL');

        $this->addSql("UPDATE line SET color = '#A46423', symbol = 'B' WHERE idLine = 1");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line DROP color, DROP symbol');
    }
}