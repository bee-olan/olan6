<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230122143243 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_sezon_tochka_tochmatkas (id UUID NOT NULL, tochka_id UUID NOT NULL, childmatka_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DD093AA5E80C2537 ON paseka_sezon_tochka_tochmatkas (tochka_id)');
        $this->addSql('CREATE INDEX IDX_DD093AA5713A01FB ON paseka_sezon_tochka_tochmatkas (childmatka_id)');
        $this->addSql('COMMENT ON COLUMN paseka_sezon_tochka_tochmatkas.id IS \'(DC2Type:paseka_sezon_tochka_tochmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_sezon_tochka_tochmatkas.tochka_id IS \'(DC2Type:paseka_sezon_tochka_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_sezon_tochka_tochmatkas.childmatka_id IS \'(DC2Type:paseka_matkas_childmatka_id)\'');
        $this->addSql('ALTER TABLE paseka_sezon_tochka_tochmatkas ADD CONSTRAINT FK_DD093AA5E80C2537 FOREIGN KEY (tochka_id) REFERENCES paseka_sezon_tochkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_sezon_tochka_tochmatkas ADD CONSTRAINT FK_DD093AA5713A01FB FOREIGN KEY (childmatka_id) REFERENCES paseka_matkas_childmatkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE paseka_matkas_childmatkas_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE paseka_sezon_tochka_tochmatkas');
    }
}
