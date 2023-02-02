<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230202180146 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_matkas_child_files (id UUID NOT NULL, childmatka_id INT NOT NULL, uchastie_id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, info_path VARCHAR(255) NOT NULL, info_name VARCHAR(255) NOT NULL, info_size INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E16E7701713A01FB ON paseka_matkas_child_files (childmatka_id)');
        $this->addSql('CREATE INDEX IDX_E16E77016931F8F9 ON paseka_matkas_child_files (uchastie_id)');
        $this->addSql('CREATE INDEX IDX_E16E7701AA9E377A ON paseka_matkas_child_files (date)');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_child_files.id IS \'(DC2Type:paseka_matkas_child_file_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_child_files.childmatka_id IS \'(DC2Type:paseka_matkas_childmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_child_files.uchastie_id IS \'(DC2Type:paseka_uchasties_uchastie_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_child_files.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE paseka_matkas_child_files ADD CONSTRAINT FK_E16E7701713A01FB FOREIGN KEY (childmatka_id) REFERENCES paseka_matkas_childmatkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_matkas_child_files ADD CONSTRAINT FK_E16E77016931F8F9 FOREIGN KEY (uchastie_id) REFERENCES paseka_uchasties_uchasties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE paseka_matkas_childmatkas_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE paseka_matkas_child_files');
    }
}
