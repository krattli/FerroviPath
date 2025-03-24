<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250324163729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'permet de jouer et sauvegarder des parties même si on est pas connecté \n donc en résumé de pouvoir avoir des user=null dans la table game';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game CHANGE id_user id_user INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game CHANGE id_user id_user INT NOT NULL');
    }
}
