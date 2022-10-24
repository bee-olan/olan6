<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221024144958 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paseka_matkas_plemmatkas ADD sparing_id UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_plemmatkas.sparing_id IS \'(DC2Type:paseka_matkas_sparing_id)\'');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatkas ADD CONSTRAINT FK_8ED8CB4B5FE9B039 FOREIGN KEY (sparing_id) REFERENCES paseka_matkas_sparings (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8ED8CB4B5FE9B039 ON paseka_matkas_plemmatkas (sparing_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE paseka_matkas_plemmatkas DROP CONSTRAINT FK_8ED8CB4B5FE9B039');
        $this->addSql('DROP INDEX IDX_8ED8CB4B5FE9B039');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatkas DROP sparing_id');
    }
}
