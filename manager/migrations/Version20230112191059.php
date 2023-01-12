<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230112191059 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sezon_goda_wzatoks (id UUID NOT NULL, goda_id UUID NOT NULL, content TEXT DEFAULT NULL, kolwz SMALLINT NOT NULL, gruppa SMALLINT NOT NULL, uchastie_id VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D8620A7E5CF74D53 ON sezon_goda_wzatoks (goda_id)');
        $this->addSql('COMMENT ON COLUMN sezon_goda_wzatoks.id IS \'(DC2Type:sezon_goda_wzatok_id)\'');
        $this->addSql('ALTER TABLE sezon_goda_wzatoks ADD CONSTRAINT FK_D8620A7E5CF74D53 FOREIGN KEY (goda_id) REFERENCES sezons_godas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sezons_godas ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE sezons_godas ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE paseka_matkas_childmatkas_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE sezon_goda_wzatoks');
        $this->addSql('ALTER TABLE sezons_godas ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE sezons_godas ALTER id DROP DEFAULT');
    }
}
