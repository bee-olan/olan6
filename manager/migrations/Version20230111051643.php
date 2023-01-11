<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230111051643 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paseka_matkas_childmatkas ADD zakaz_date DATE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_childmatkas.zakaz_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE sezons_godas ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE sezons_godas ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE paseka_matkas_childmatkas_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE paseka_matkas_childmatkas DROP zakaz_date');
        $this->addSql('ALTER TABLE sezons_godas ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE sezons_godas ALTER id DROP DEFAULT');
    }
}
