<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221107111100 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_matkas_childmatkas (id INT NOT NULL, plemmatka_id UUID NOT NULL, author_id UUID NOT NULL, parent_id INT DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, plan_date DATE DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, name VARCHAR(255) NOT NULL, content TEXT DEFAULT NULL, type VARCHAR(16) NOT NULL, progress SMALLINT NOT NULL, priority SMALLINT NOT NULL, status VARCHAR(16) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D9AC51749D579D57 ON paseka_matkas_childmatkas (plemmatka_id)');
        $this->addSql('CREATE INDEX IDX_D9AC5174F675F31B ON paseka_matkas_childmatkas (author_id)');
        $this->addSql('CREATE INDEX IDX_D9AC5174727ACA70 ON paseka_matkas_childmatkas (parent_id)');
        $this->addSql('CREATE INDEX IDX_D9AC5174AA9E377A ON paseka_matkas_childmatkas (date)');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_childmatkas.id IS \'(DC2Type:paseka_matkas_childmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_childmatkas.plemmatka_id IS \'(DC2Type:paseka_matkas_plemmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_childmatkas.author_id IS \'(DC2Type:paseka_uchasties_uchastie_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_childmatkas.parent_id IS \'(DC2Type:paseka_matkas_childmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_childmatkas.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_childmatkas.plan_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_childmatkas.start_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_childmatkas.end_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_childmatkas.type IS \'(DC2Type:paseka_matkas_childmatka_type)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_childmatkas.status IS \'(DC2Type:paseka_matkas_childmatka_status)\'');
        $this->addSql('CREATE TABLE paseka_matkas_childmatkas_executors (childmatka_id INT NOT NULL, uchastie_id UUID NOT NULL, PRIMARY KEY(childmatka_id, uchastie_id))');
        $this->addSql('CREATE INDEX IDX_8EE9CED2713A01FB ON paseka_matkas_childmatkas_executors (childmatka_id)');
        $this->addSql('CREATE INDEX IDX_8EE9CED26931F8F9 ON paseka_matkas_childmatkas_executors (uchastie_id)');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_childmatkas_executors.childmatka_id IS \'(DC2Type:paseka_matkas_childmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_childmatkas_executors.uchastie_id IS \'(DC2Type:paseka_uchasties_uchastie_id)\'');
        $this->addSql('ALTER TABLE paseka_matkas_childmatkas ADD CONSTRAINT FK_D9AC51749D579D57 FOREIGN KEY (plemmatka_id) REFERENCES paseka_matkas_plemmatkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_matkas_childmatkas ADD CONSTRAINT FK_D9AC5174F675F31B FOREIGN KEY (author_id) REFERENCES paseka_uchasties_uchasties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_matkas_childmatkas ADD CONSTRAINT FK_D9AC5174727ACA70 FOREIGN KEY (parent_id) REFERENCES paseka_matkas_childmatkas (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_matkas_childmatkas_executors ADD CONSTRAINT FK_8EE9CED2713A01FB FOREIGN KEY (childmatka_id) REFERENCES paseka_matkas_childmatkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_matkas_childmatkas_executors ADD CONSTRAINT FK_8EE9CED26931F8F9 FOREIGN KEY (uchastie_id) REFERENCES paseka_uchasties_uchasties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        
        $this->addSql('ALTER TABLE paseka_matkas_childmatkas DROP CONSTRAINT FK_D9AC5174727ACA70');
        $this->addSql('ALTER TABLE paseka_matkas_childmatkas_executors DROP CONSTRAINT FK_8EE9CED2713A01FB');
        $this->addSql('DROP TABLE paseka_matkas_childmatkas');
        $this->addSql('DROP TABLE paseka_matkas_childmatkas_executors');
    }
}
