<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221103104343 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paseka_uchasties_uchasties ADD date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE paseka_uchasties_uchasties ADD uchkak VARCHAR(16) NOT NULL');
        $this->addSql('COMMENT ON COLUMN paseka_uchasties_uchasties.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN paseka_uchasties_uchasties.uchkak IS \'(DC2Type:paseka_uchasties_uchastie_uchkak)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE paseka_uchasties_uchasties DROP date');
        $this->addSql('ALTER TABLE paseka_uchasties_uchasties DROP uchkak');
    }
}
