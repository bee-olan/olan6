<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221115100932 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE paseka_matkas_plemmatkas DROP CONSTRAINT fk_8ed8cb4b5fe9b039');
        $this->addSql('DROP INDEX idx_8ed8cb4b5fe9b039');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatkas ADD kategoria_id UUID NOT NULL');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatkas DROP sparing_id');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_plemmatkas.kategoria_id IS \'(DC2Type:paseka_matkas_kategoria_id)\'');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatkas ADD CONSTRAINT FK_8ED8CB4B359B0684 FOREIGN KEY (kategoria_id) REFERENCES paseka_matkas_kategorias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8ED8CB4B359B0684 ON paseka_matkas_plemmatkas (kategoria_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('CREATE SEQUENCE paseka_matkas_childmatkas_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatkas DROP CONSTRAINT FK_8ED8CB4B359B0684');
        $this->addSql('DROP INDEX IDX_8ED8CB4B359B0684');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatkas ADD sparing_id UUID NOT NULL');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatkas DROP kategoria_id');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_plemmatkas.sparing_id IS \'(DC2Type:paseka_matkas_sparing_id)\'');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatkas ADD CONSTRAINT fk_8ed8cb4b5fe9b039 FOREIGN KEY (sparing_id) REFERENCES paseka_matkas_sparings (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8ed8cb4b5fe9b039 ON paseka_matkas_plemmatkas (sparing_id)');
    }
}
