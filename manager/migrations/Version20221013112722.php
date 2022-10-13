<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221013112722 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_rasa_linia_nomers (id UUID NOT NULL, linia_id UUID NOT NULL, sparing_id UUID NOT NULL, name VARCHAR(255) NOT NULL, name_star VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, sort_nomer INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E27350F8400E94F9 ON paseka_rasa_linia_nomers (linia_id)');
        $this->addSql('CREATE INDEX IDX_E27350F85FE9B039 ON paseka_rasa_linia_nomers (sparing_id)');
        $this->addSql('COMMENT ON COLUMN paseka_rasa_linia_nomers.id IS \'(DC2Type:paseka_rasa_linia_nomer_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_rasa_linia_nomers.linia_id IS \'(DC2Type:paseka_rasa_linia_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_rasa_linia_nomers.sparing_id IS \'(DC2Type:paseka_rasa_linia_nomer_sparing_id)\'');
        $this->addSql('ALTER TABLE paseka_rasa_linia_nomers ADD CONSTRAINT FK_E27350F8400E94F9 FOREIGN KEY (linia_id) REFERENCES paseka_rasa_linias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_rasa_linia_nomers ADD CONSTRAINT FK_E27350F85FE9B039 FOREIGN KEY (sparing_id) REFERENCES paseka_rasa_linia_nomer_sparings (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE rabota_rasa_linia_nomers');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('CREATE TABLE rabota_rasa_linia_nomers (id UUID NOT NULL, linia_id UUID NOT NULL, sparing_id UUID NOT NULL, name VARCHAR(255) NOT NULL, name_star VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, sort_nomer INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_d8f861795fe9b039 ON rabota_rasa_linia_nomers (sparing_id)');
        $this->addSql('CREATE INDEX idx_d8f86179400e94f9 ON rabota_rasa_linia_nomers (linia_id)');
        $this->addSql('COMMENT ON COLUMN rabota_rasa_linia_nomers.id IS \'(DC2Type:paseka_rasa_linia_nomer_id)\'');
        $this->addSql('COMMENT ON COLUMN rabota_rasa_linia_nomers.linia_id IS \'(DC2Type:paseka_rasa_linia_id)\'');
        $this->addSql('COMMENT ON COLUMN rabota_rasa_linia_nomers.sparing_id IS \'(DC2Type:paseka_rasa_linia_nomer_sparing_id)\'');
        $this->addSql('ALTER TABLE rabota_rasa_linia_nomers ADD CONSTRAINT fk_d8f86179400e94f9 FOREIGN KEY (linia_id) REFERENCES paseka_rasa_linias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rabota_rasa_linia_nomers ADD CONSTRAINT fk_d8f861795fe9b039 FOREIGN KEY (sparing_id) REFERENCES paseka_rasa_linia_nomer_sparings (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE paseka_rasa_linia_nomers');
    }
}
