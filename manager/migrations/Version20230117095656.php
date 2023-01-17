<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117095656 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_sezon_tochkas (id UUID NOT NULL, uchasgoda_id UUID NOT NULL, kolwz SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_92F84FC06466158F ON paseka_sezon_tochkas (uchasgoda_id)');
        $this->addSql('COMMENT ON COLUMN paseka_sezon_tochkas.id IS \'(DC2Type:paseka_sezon_tochka_id)\'');
        $this->addSql('ALTER TABLE paseka_sezon_tochkas ADD CONSTRAINT FK_92F84FC06466158F FOREIGN KEY (uchasgoda_id) REFERENCES paseka_sezons_uchasgodas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE paseka_matkas_childmatkas_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE paseka_sezon_tochkas');
    }
}
