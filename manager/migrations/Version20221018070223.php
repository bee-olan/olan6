<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221018070223 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paseka_uchasties_uchasties DROP email');
        $this->addSql('ALTER TABLE paseka_uchasties_uchasties ALTER status TYPE VARCHAR(16)');
        $this->addSql('ALTER TABLE paseka_uchasties_uchasties ALTER status DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN paseka_uchasties_uchasties.status IS \'(DC2Type:paseka_uchasties_uchastie_email)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE paseka_uchasties_uchasties ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE paseka_uchasties_uchasties ALTER status TYPE VARCHAR(16)');
        $this->addSql('ALTER TABLE paseka_uchasties_uchasties ALTER status DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN paseka_uchasties_uchasties.email IS \'(DC2Type:paseka_uchasties_uchastie_email)\'');
        $this->addSql('COMMENT ON COLUMN paseka_uchasties_uchasties.status IS \'(DC2Type:paseka_uchasties_uchastie_status)\'');
    }
}
