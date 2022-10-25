<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221025105818 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mesto_okrug_oblasts (id UUID NOT NULL, okrug_id UUID NOT NULL, name VARCHAR(255) NOT NULL, nomer VARCHAR(255) NOT NULL, mesto VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9FD54429AD71658C ON mesto_okrug_oblasts (okrug_id)');
        $this->addSql('COMMENT ON COLUMN mesto_okrug_oblasts.id IS \'(DC2Type:mesto_okrug_oblast_id)\'');
        $this->addSql('COMMENT ON COLUMN mesto_okrug_oblasts.okrug_id IS \'(DC2Type:mesto_okrug_id)\'');
        $this->addSql('ALTER TABLE mesto_okrug_oblasts ADD CONSTRAINT FK_9FD54429AD71658C FOREIGN KEY (okrug_id) REFERENCES mesto_okrugs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DROP TABLE mesto_okrug_oblasts');
    }
}
