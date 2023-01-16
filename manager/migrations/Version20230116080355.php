<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116080355 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_sezons_uchasgodas (id UUID NOT NULL, goda_id UUID NOT NULL, uchastie_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_80DEDEA45CF74D53 ON paseka_sezons_uchasgodas (goda_id)');
        $this->addSql('CREATE INDEX IDX_80DEDEA46931F8F9 ON paseka_sezons_uchasgodas (uchastie_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_80DEDEA45CF74D536931F8F9 ON paseka_sezons_uchasgodas (goda_id, uchastie_id)');
        $this->addSql('COMMENT ON COLUMN paseka_sezons_uchasgodas.goda_id IS \'(DC2Type:paseka_sezons_goda_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_sezons_uchasgodas.uchastie_id IS \'(DC2Type:paseka_uchasties_uchastie_id)\'');
        $this->addSql('ALTER TABLE paseka_sezons_uchasgodas ADD CONSTRAINT FK_80DEDEA45CF74D53 FOREIGN KEY (goda_id) REFERENCES paseka_sezons_godas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_sezons_uchasgodas ADD CONSTRAINT FK_80DEDEA46931F8F9 FOREIGN KEY (uchastie_id) REFERENCES paseka_uchasties_uchasties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE paseka_matkas_childmatkas_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE paseka_sezons_uchasgodas');
    }
}
