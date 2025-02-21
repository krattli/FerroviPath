<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250220121443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON line');
        $this->addSql('ALTER TABLE line DROP id, CHANGE id_line id_line INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE line ADD PRIMARY KEY (id_line)');
        $this->addSql('ALTER TABLE station ADD axis_x INT NOT NULL, ADD axis_y INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL, DROP id_user, CHANGE birth birth DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL ON user');
        $this->addSql('ALTER TABLE user ADD id_user INT NOT NULL, DROP roles, CHANGE email email VARCHAR(255) NOT NULL, CHANGE birth birth DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE station DROP axis_x, DROP axis_y');
        $this->addSql('ALTER TABLE line ADD id INT AUTO_INCREMENT NOT NULL, CHANGE id_line id_line VARCHAR(255) DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
