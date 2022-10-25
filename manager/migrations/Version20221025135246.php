<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221025135246 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mesto_okrug_oblast_raions (id UUID NOT NULL, oblast_id UUID NOT NULL, name VARCHAR(255) NOT NULL, nomer VARCHAR(255) NOT NULL, mesto VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6A54E56BB8CB685 ON mesto_okrug_oblast_raions (oblast_id)');
        $this->addSql('COMMENT ON COLUMN mesto_okrug_oblast_raions.id IS \'(DC2Type:mesto_okrug_oblast_raion_id)\'');
        $this->addSql('COMMENT ON COLUMN mesto_okrug_oblast_raions.oblast_id IS \'(DC2Type:mesto_okrug_oblast_id)\'');
        $this->addSql('ALTER TABLE mesto_okrug_oblast_raions ADD CONSTRAINT FK_6A54E56BB8CB685 FOREIGN KEY (oblast_id) REFERENCES mesto_okrug_oblasts (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DROP TABLE mesto_okrug_oblast_raions');
    }
}
