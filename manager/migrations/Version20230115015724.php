<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230115015724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_sezons_nachalos (id UUID NOT NULL, goda_id UUID NOT NULL, koltochek SMALLINT NOT NULL, gruppa VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_73C4DC6F5CF74D53 ON paseka_sezons_nachalos (goda_id)');
        $this->addSql('COMMENT ON COLUMN paseka_sezons_nachalos.id IS \'(DC2Type:paseka_sezons_nachalo_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_sezons_nachalos.goda_id IS \'(DC2Type:paseka_sezons_goda_id)\'');
        $this->addSql('ALTER TABLE paseka_sezons_nachalos ADD CONSTRAINT FK_73C4DC6F5CF74D53 FOREIGN KEY (goda_id) REFERENCES paseka_sezons_godas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sezon_goda_wzatoks ALTER goda_id TYPE UUID');
        $this->addSql('ALTER TABLE sezon_goda_wzatoks ALTER goda_id DROP DEFAULT');
        $this->addSql('ALTER TABLE sezons_godas ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE sezons_godas ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE paseka_matkas_childmatkas_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE paseka_sezons_nachalos');
        $this->addSql('ALTER TABLE sezons_godas ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE sezons_godas ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE sezon_goda_wzatoks ALTER goda_id TYPE UUID');
        $this->addSql('ALTER TABLE sezon_goda_wzatoks ALTER goda_id DROP DEFAULT');
    }
}
