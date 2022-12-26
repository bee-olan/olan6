<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221226045319 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paseka_matkas_childmatkas ADD sparing_id UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_childmatkas.sparing_id IS \'(DC2Type:paseka_matkas_sparing_id)\'');
        $this->addSql('ALTER TABLE paseka_matkas_childmatkas ADD CONSTRAINT FK_D9AC51745FE9B039 FOREIGN KEY (sparing_id) REFERENCES paseka_matkas_sparings (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D9AC51745FE9B039 ON paseka_matkas_childmatkas (sparing_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
 
        $this->addSql('CREATE SEQUENCE paseka_matkas_childmatkas_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE paseka_matkas_childmatkas DROP CONSTRAINT FK_D9AC51745FE9B039');
        $this->addSql('DROP INDEX IDX_D9AC51745FE9B039');
        $this->addSql('ALTER TABLE paseka_matkas_childmatkas DROP sparing_id');
    }
}
