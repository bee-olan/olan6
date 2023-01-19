<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230119094711 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_sezon_tochka_wzatoks (id UUID NOT NULL, tochka_id UUID NOT NULL, start_date DATE DEFAULT NULL, pobelka_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, rasstojan SMALLINT NOT NULL, nomerwz SMALLINT NOT NULL, gruppa VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A15C0A25E80C2537 ON paseka_sezon_tochka_wzatoks (tochka_id)');
        $this->addSql('COMMENT ON COLUMN paseka_sezon_tochka_wzatoks.id IS \'(DC2Type:paseka_sezon_tochka_wzatok_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_sezon_tochka_wzatoks.tochka_id IS \'(DC2Type:paseka_sezon_tochka_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_sezon_tochka_wzatoks.start_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN paseka_sezon_tochka_wzatoks.pobelka_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN paseka_sezon_tochka_wzatoks.end_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE paseka_sezon_tochka_wzatoks ADD CONSTRAINT FK_A15C0A25E80C2537 FOREIGN KEY (tochka_id) REFERENCES paseka_sezon_tochkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_sezon_tochkas ADD name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE paseka_matkas_childmatkas_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE paseka_sezon_tochka_wzatoks');
        $this->addSql('ALTER TABLE paseka_sezon_tochkas DROP name');
    }
}
