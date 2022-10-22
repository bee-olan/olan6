<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221022134200 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_matkas_plemmatkas (id UUID NOT NULL, name VARCHAR(255) NOT NULL, sort INT NOT NULL, status VARCHAR(16) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_plemmatkas.id IS \'(DC2Type:paseka_matkas_plemmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_plemmatkas.status IS \'(DC2Type:paseka_matkas_plemmatka_status)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DROP TABLE paseka_matkas_plemmatkas');
    }
}
