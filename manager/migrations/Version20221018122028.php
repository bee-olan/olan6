<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221018122028 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_uchasties_personas (id UUID NOT NULL, nomer INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN paseka_uchasties_personas.id IS \'(DC2Type:paseka_uchasties_persona_id)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DROP TABLE paseka_uchasties_personas');
    }
}
