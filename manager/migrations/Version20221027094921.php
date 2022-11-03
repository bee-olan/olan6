<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221027094921 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mesto_mestonomers ALTER raion_id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE mesto_mestonomers ALTER raion_id DROP DEFAULT');
        $this->addSql('ALTER TABLE mesto_mestonomers ALTER nomer TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE mesto_mestonomers ALTER nomer DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE mesto_mestonomers ALTER raion_id TYPE INT');
        $this->addSql('ALTER TABLE mesto_mestonomers ALTER raion_id DROP DEFAULT');
        $this->addSql('ALTER TABLE mesto_mestonomers ALTER nomer TYPE INT');
        $this->addSql('ALTER TABLE mesto_mestonomers ALTER nomer DROP DEFAULT');
    }
}