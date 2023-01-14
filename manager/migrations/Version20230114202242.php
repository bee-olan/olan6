<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230114202242 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_sezons_godas (id UUID NOT NULL, god INT NOT NULL, sezon VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN paseka_sezons_godas.id IS \'(DC2Type:paseka_sezons_goda_id)\'');
        $this->addSql('ALTER TABLE sezon_goda_wzatoks ALTER goda_id TYPE UUID');
        $this->addSql('ALTER TABLE sezon_goda_wzatoks ALTER goda_id DROP DEFAULT');
        $this->addSql('ALTER TABLE sezons_godas ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE sezons_godas ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE paseka_matkas_childmatkas_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE paseka_sezons_godas');
        $this->addSql('ALTER TABLE sezons_godas ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE sezons_godas ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE sezon_goda_wzatoks ALTER goda_id TYPE UUID');
        $this->addSql('ALTER TABLE sezon_goda_wzatoks ALTER goda_id DROP DEFAULT');
    }
}
