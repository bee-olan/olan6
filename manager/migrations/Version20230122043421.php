<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230122043421 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paseka_sezon_tochka_wzatoks ADD rabotad SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE paseka_sezon_tochka_wzatoks ADD rabotach SMALLINT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE paseka_matkas_childmatkas_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE paseka_sezon_tochka_wzatoks DROP rabotad');
        $this->addSql('ALTER TABLE paseka_sezon_tochka_wzatoks DROP rabotach');
    }
}
