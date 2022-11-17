<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221114190812 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('CREATE TABLE paseka_matkas_kategorias (id UUID NOT NULL, name VARCHAR(255) NOT NULL, permissions JSON NOT NULL, version INT DEFAULT 1 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1B633F645E237E06 ON paseka_matkas_kategorias (name)');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_kategorias.id IS \'(DC2Type:paseka_matkas_kategoria_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_kategorias.permissions IS \'(DC2Type:paseka_matkas_kategoria_permissions)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('CREATE SEQUENCE paseka_matkas_childmatkas_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE paseka_matkas_kategorias');
    }
}
