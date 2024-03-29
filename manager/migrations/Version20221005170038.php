<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221005170038 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_users ADD uchkak VARCHAR(16) NOT NULL');
        $this->addSql('COMMENT ON COLUMN user_users.uchkak IS \'(DC2Type:user_user_uchkak)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
       
        $this->addSql('ALTER TABLE user_users DROP uchkak');
    }
}
