<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221017065454 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_uchasties_groups (id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN paseka_uchasties_groups.id IS \'(DC2Type:paseka_uchasties_group_id)\'');
        $this->addSql('CREATE TABLE paseka_uchasties_uchasties (id UUID NOT NULL, group_id UUID NOT NULL, email VARCHAR(255) NOT NULL, status VARCHAR(16) NOT NULL, name_first VARCHAR(255) NOT NULL, name_last VARCHAR(255) NOT NULL, name_nike VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FC8FDFADFE54D947 ON paseka_uchasties_uchasties (group_id)');
        $this->addSql('COMMENT ON COLUMN paseka_uchasties_uchasties.id IS \'(DC2Type:paseka_uchasties_uchastie_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_uchasties_uchasties.group_id IS \'(DC2Type:paseka_uchasties_group_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_uchasties_uchasties.email IS \'(DC2Type:paseka_uchasties_uchastie_status)\'');
        $this->addSql('COMMENT ON COLUMN paseka_uchasties_uchasties.status IS \'(DC2Type:paseka_uchasties_uchastie_email)\'');
        $this->addSql('ALTER TABLE paseka_uchasties_uchasties ADD CONSTRAINT FK_FC8FDFADFE54D947 FOREIGN KEY (group_id) REFERENCES paseka_uchasties_groups (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE paseka_uchasties_uchasties DROP CONSTRAINT FK_FC8FDFADFE54D947');
        $this->addSql('DROP TABLE paseka_uchasties_groups');
        $this->addSql('DROP TABLE paseka_uchasties_uchasties');
    }
}
