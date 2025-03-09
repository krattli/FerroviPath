<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250309160936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id_game INT AUTO_INCREMENT NOT NULL, id_line INT NOT NULL, id_user INT NOT NULL, game_mode VARCHAR(255) NOT NULL, time DOUBLE PRECISION NOT NULL, score_points INT NOT NULL, completed_stations JSON DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_232B318C5A34A8F4 (id_line), INDEX IDX_232B318C6B3CA4B (id_user), PRIMARY KEY(id_game)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE line (idLine INT AUTO_INCREMENT NOT NULL, name_line VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(idLine)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station (id_station INT AUTO_INCREMENT NOT NULL, id_line INT NOT NULL, name_station VARCHAR(255) NOT NULL, axis_x DOUBLE PRECISION NOT NULL, axis_y DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at VARCHAR(255) NOT NULL, deleted_at VARCHAR(255) DEFAULT NULL, INDEX IDX_9F39F8B15A34A8F4 (id_line), PRIMARY KEY(id_station)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (idUser INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(255) DEFAULT NULL, birth DATETIME NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(idUser)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C5A34A8F4 FOREIGN KEY (id_line) REFERENCES line (idLine)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C6B3CA4B FOREIGN KEY (id_user) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B15A34A8F4 FOREIGN KEY (id_line) REFERENCES line (idLine)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C5A34A8F4');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C6B3CA4B');
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B15A34A8F4');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE line');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE user');
    }
}
