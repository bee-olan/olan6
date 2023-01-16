<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116152756 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paseka_sezons_uchasgodas ADD koltochek SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE paseka_sezons_uchasgodas ADD gruppa VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE paseka_matkas_childmatkas_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE paseka_sezons_uchasgodas DROP koltochek');
        $this->addSql('ALTER TABLE paseka_sezons_uchasgodas DROP gruppa');
    }
}
