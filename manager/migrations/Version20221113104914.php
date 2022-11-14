<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221113104914 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE paseka_matkas_childmatkas_seq CASCADE');
        $this->addSql('CREATE TABLE paseka_matkas_plemmatka_uchastniks (id UUID NOT NULL, plemmatka_id UUID NOT NULL, uchastie_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_374A3C559D579D57 ON paseka_matkas_plemmatka_uchastniks (plemmatka_id)');
        $this->addSql('CREATE INDEX IDX_374A3C556931F8F9 ON paseka_matkas_plemmatka_uchastniks (uchastie_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_374A3C559D579D576931F8F9 ON paseka_matkas_plemmatka_uchastniks (plemmatka_id, uchastie_id)');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_plemmatka_uchastniks.plemmatka_id IS \'(DC2Type:paseka_matkas_plemmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_plemmatka_uchastniks.uchastie_id IS \'(DC2Type:paseka_uchasties_uchastie_id)\'');
        $this->addSql('CREATE TABLE paseka_matkas_plemmatka_uchastnik_departments (uchastnik_id UUID NOT NULL, department_id UUID NOT NULL, PRIMARY KEY(uchastnik_id, department_id))');
        $this->addSql('CREATE INDEX IDX_B407EE806E2164AC ON paseka_matkas_plemmatka_uchastnik_departments (uchastnik_id)');
        $this->addSql('CREATE INDEX IDX_B407EE80AE80F5DF ON paseka_matkas_plemmatka_uchastnik_departments (department_id)');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_plemmatka_uchastnik_departments.department_id IS \'(DC2Type:paseka_matkas_plemmatka_department_id)\'');
        $this->addSql('CREATE TABLE paseka_matkas_plemmatka_uchastnik_roles (uchastnik_id UUID NOT NULL, role_id UUID NOT NULL, PRIMARY KEY(uchastnik_id, role_id))');
        $this->addSql('CREATE INDEX IDX_6154440A6E2164AC ON paseka_matkas_plemmatka_uchastnik_roles (uchastnik_id)');
        $this->addSql('CREATE INDEX IDX_6154440AD60322AC ON paseka_matkas_plemmatka_uchastnik_roles (role_id)');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_plemmatka_uchastnik_roles.role_id IS \'(DC2Type:paseka_matkas_role_id)\'');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatka_uchastniks ADD CONSTRAINT FK_374A3C559D579D57 FOREIGN KEY (plemmatka_id) REFERENCES paseka_matkas_plemmatkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatka_uchastniks ADD CONSTRAINT FK_374A3C556931F8F9 FOREIGN KEY (uchastie_id) REFERENCES paseka_uchasties_uchasties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatka_uchastnik_departments ADD CONSTRAINT FK_B407EE806E2164AC FOREIGN KEY (uchastnik_id) REFERENCES paseka_matkas_plemmatka_uchastniks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatka_uchastnik_departments ADD CONSTRAINT FK_B407EE80AE80F5DF FOREIGN KEY (department_id) REFERENCES paseka_matkas_plemmatka_departments (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatka_uchastnik_roles ADD CONSTRAINT FK_6154440A6E2164AC FOREIGN KEY (uchastnik_id) REFERENCES paseka_matkas_plemmatka_uchastniks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatka_uchastnik_roles ADD CONSTRAINT FK_6154440AD60322AC FOREIGN KEY (role_id) REFERENCES paseka_matkas_roles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE paseka_matkas_plemmatkas_uchastniks');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE paseka_matkas_plemmatka_uchastnik_departments DROP CONSTRAINT FK_B407EE806E2164AC');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatka_uchastnik_roles DROP CONSTRAINT FK_6154440A6E2164AC');
        $this->addSql('CREATE SEQUENCE paseka_matkas_childmatkas_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE paseka_matkas_plemmatkas_uchastniks (id UUID NOT NULL, plemmatka_id UUID NOT NULL, uchastie_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_15c653cd9d579d576931f8f9 ON paseka_matkas_plemmatkas_uchastniks (plemmatka_id, uchastie_id)');
        $this->addSql('CREATE INDEX idx_15c653cd6931f8f9 ON paseka_matkas_plemmatkas_uchastniks (uchastie_id)');
        $this->addSql('CREATE INDEX idx_15c653cd9d579d57 ON paseka_matkas_plemmatkas_uchastniks (plemmatka_id)');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_plemmatkas_uchastniks.plemmatka_id IS \'(DC2Type:paseka_matkas_plemmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_plemmatkas_uchastniks.uchastie_id IS \'(DC2Type:paseka_uchasties_uchastie_id)\'');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatkas_uchastniks ADD CONSTRAINT fk_15c653cd9d579d57 FOREIGN KEY (plemmatka_id) REFERENCES paseka_matkas_plemmatkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_matkas_plemmatkas_uchastniks ADD CONSTRAINT fk_15c653cd6931f8f9 FOREIGN KEY (uchastie_id) REFERENCES paseka_uchasties_uchasties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE paseka_matkas_plemmatka_uchastniks');
        $this->addSql('DROP TABLE paseka_matkas_plemmatka_uchastnik_departments');
        $this->addSql('DROP TABLE paseka_matkas_plemmatka_uchastnik_roles');
    }
}
