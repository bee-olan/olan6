<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230205203142 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_matkas_child_changes (id INT NOT NULL, childmatka_id INT NOT NULL, actor_id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, set_plemmatka_id UUID DEFAULT NULL, set_name VARCHAR(255) DEFAULT NULL, set_content TEXT DEFAULT NULL, set_file_id UUID DEFAULT NULL, set_removed_file_id UUID DEFAULT NULL, set_type VARCHAR(16) DEFAULT NULL, set_status VARCHAR(255) DEFAULT NULL, set_progress SMALLINT DEFAULT NULL, set_priority SMALLINT DEFAULT NULL, set_parent_id INT DEFAULT NULL, set_removed_parent BOOLEAN DEFAULT NULL, set_plan DATE DEFAULT NULL, set_removed_plan BOOLEAN DEFAULT NULL, set_executor_id UUID DEFAULT NULL, set_revoked_executor_id UUID DEFAULT NULL, PRIMARY KEY(childmatka_id, id))');
        $this->addSql('CREATE INDEX IDX_EAFF2D35713A01FB ON paseka_matkas_child_changes (childmatka_id)');
        $this->addSql('CREATE INDEX IDX_EAFF2D3510DAF24A ON paseka_matkas_child_changes (actor_id)');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_child_changes.id IS \'(DC2Type:paseka_matkas_child_change_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_child_changes.childmatka_id IS \'(DC2Type:paseka_matkas_childmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_child_changes.actor_id IS \'(DC2Type:paseka_uchasties_uchastie_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_child_changes.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_child_changes.set_plemmatka_id IS \'(DC2Type:paseka_matkas_plemmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_child_changes.set_file_id IS \'(DC2Type:paseka_matkas_child_file_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_child_changes.set_removed_file_id IS \'(DC2Type:paseka_matkas_child_file_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_child_changes.set_type IS \'(DC2Type:paseka_matkas_childmatka_type)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_child_changes.set_status IS \'(DC2Type:paseka_matkas_childmatka_status)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_child_changes.set_parent_id IS \'(DC2Type:paseka_matkas_childmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_child_changes.set_plan IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_child_changes.set_executor_id IS \'(DC2Type:paseka_uchasties_uchastie_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_matkas_child_changes.set_revoked_executor_id IS \'(DC2Type:paseka_uchasties_uchastie_id)\'');
        $this->addSql('ALTER TABLE paseka_matkas_child_changes ADD CONSTRAINT FK_EAFF2D35713A01FB FOREIGN KEY (childmatka_id) REFERENCES paseka_matkas_childmatkas (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_matkas_child_changes ADD CONSTRAINT FK_EAFF2D3510DAF24A FOREIGN KEY (actor_id) REFERENCES paseka_uchasties_uchasties (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment_comments DROP version');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE paseka_matkas_child_changes');
        $this->addSql('ALTER TABLE comment_comments ADD version INT DEFAULT 1 NOT NULL');
    }
}
