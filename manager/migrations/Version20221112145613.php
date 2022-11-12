<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221112145613 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE paseka_matkas_childmatkas_seq CASCADE');
        $this->addSql('CREATE TABLE paseka_matkas_plemmatka_departments (id UUID NOT NULL, plemmatka_id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_97CD31999D579D57 ON paseka_matkas_plemmatka_departments (plemmatka_id)');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_plemmatka_departments.id IS \'(DC2Type:paseka_matkas_plemmatka_department_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_plemmatka_departments.plemmatka_id IS \'(DC2Type:paseka_matkas_plemmatka_id)\'');
        $this->addSql('CREATE TABLE paseka_matkas_plemmatkas_uchastniks (id UUID NOT NULL, plemmatka_id UUID NOT NULL, uchastie_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_15C653CD9D579D57 ON paseka_matkas_plemmatkas_uchastniks (plemmatka_id)');
        $this->addSql('CREATE INDEX IDX_15C653CD6931F8F9 ON paseka_matkas_plemmatkas_uchastniks (uchastie_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_15C653CD9D579D576931F8F9 ON paseka_matkas_plemmatkas_uchastniks (plemmatka_id, uchastie_id)');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_plemmatkas_uchastniks.plemmatka_id IS \'(DC2Type:paseka_matkas_plemmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_plemmatkas_uchastniks.uchastie_id IS \'(DC2Type:paseka_uchasties_uchastie_id)\'');
        $this->addSql('CREATE TABLE paseka_matkas_roles (id UUID NOT NULL, name VARCHAR(255) NOT NULL, permissions JSON NOT NULL, version INT DEFAULT 1 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_37BDAB665E237E06 ON paseka_matkas_roles (name)');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_roles.id IS \'(DC2Type:paseka_matkas_role_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_roles.permissions IS \'(DC2Type:paseka_matkas_role_permissions)\'');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatka_departments ADD CONSTRAINT FK_97CD31999D579D57 FOREIGN KEY (plemmatka_id) REFERENCES paseka_matkas_plemmatkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatkas_uchastniks ADD CONSTRAINT FK_15C653CD9D579D57 FOREIGN KEY (plemmatka_id) REFERENCES paseka_matkas_plemmatkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatkas_uchastniks ADD CONSTRAINT FK_15C653CD6931F8F9 FOREIGN KEY (uchastie_id) REFERENCES paseka_uchasties_uchasties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('CREATE SEQUENCE paseka_matkas_childmatkas_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE paseka_matkas_plemmatka_departments');
        $this->addSql('DROP TABLE paseka_matkas_plemmatkas_uchastniks');
        $this->addSql('DROP TABLE paseka_matkas_roles');
    }
}
