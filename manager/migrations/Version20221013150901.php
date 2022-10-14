<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221013150901 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_rasa_linia_nomer_sparings (id UUID NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN paseka_rasa_linia_nomer_sparings.id IS \'(DC2Type:paseka_rasa_linia_nomer_sparing_id)\'');
        $this->addSql('CREATE TABLE paseka_rasa_linia_nomers (id UUID NOT NULL, linia_id UUID NOT NULL, sparing_id UUID NOT NULL, name VARCHAR(255) NOT NULL, name_star VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, sort_nomer INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E27350F8400E94F9 ON paseka_rasa_linia_nomers (linia_id)');
        $this->addSql('CREATE INDEX IDX_E27350F85FE9B039 ON paseka_rasa_linia_nomers (sparing_id)');
        $this->addSql('COMMENT ON COLUMN paseka_rasa_linia_nomers.id IS \'(DC2Type:paseka_rasa_linia_nomer_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_rasa_linia_nomers.linia_id IS \'(DC2Type:paseka_rasa_linia_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_rasa_linia_nomers.sparing_id IS \'(DC2Type:paseka_rasa_linia_nomer_sparing_id)\'');
        $this->addSql('CREATE TABLE paseka_rasa_linias (id UUID NOT NULL, rasa_id UUID NOT NULL, name VARCHAR(255) NOT NULL, name_star VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, sort_linia INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D9D0DB5C81DBD4D8 ON paseka_rasa_linias (rasa_id)');
        $this->addSql('COMMENT ON COLUMN paseka_rasa_linias.id IS \'(DC2Type:paseka_rasa_linia_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_rasa_linias.rasa_id IS \'(DC2Type:paseka_rasa_id)\'');
        $this->addSql('CREATE TABLE paseka_rasas (id UUID NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN paseka_rasas.id IS \'(DC2Type:paseka_rasa_id)\'');
        $this->addSql('ALTER TABLE paseka_rasa_linia_nomers ADD CONSTRAINT FK_E27350F8400E94F9 FOREIGN KEY (linia_id) REFERENCES paseka_rasa_linias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_rasa_linia_nomers ADD CONSTRAINT FK_E27350F85FE9B039 FOREIGN KEY (sparing_id) REFERENCES paseka_rasa_linia_nomer_sparings (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_rasa_linias ADD CONSTRAINT FK_D9D0DB5C81DBD4D8 FOREIGN KEY (rasa_id) REFERENCES paseka_rasas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE paseka_rasa_linia_nomers DROP CONSTRAINT FK_E27350F85FE9B039');
        $this->addSql('ALTER TABLE paseka_rasa_linia_nomers DROP CONSTRAINT FK_E27350F8400E94F9');
        $this->addSql('ALTER TABLE paseka_rasa_linias DROP CONSTRAINT FK_D9D0DB5C81DBD4D8');
        $this->addSql('DROP TABLE paseka_rasa_linia_nomer_sparings');
        $this->addSql('DROP TABLE paseka_rasa_linia_nomers');
        $this->addSql('DROP TABLE paseka_rasa_linias');
        $this->addSql('DROP TABLE paseka_rasas');
    }
}
