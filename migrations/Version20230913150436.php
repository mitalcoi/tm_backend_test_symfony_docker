<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913150436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE user_progress_track_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE question_with_answers (id UUID NOT NULL, root_id VARCHAR(255) DEFAULT NULL, question VARCHAR(255) NOT NULL, answer_options JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CAD703A779066886 ON question_with_answers (root_id)');
        $this->addSql('CREATE TABLE questionnaire_root (id VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_progress (id UUID NOT NULL, root_id VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, finished_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C28C164679066886 ON user_progress (root_id)');
        $this->addSql('COMMENT ON COLUMN user_progress.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_progress.finished_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_progress_track (id INT NOT NULL, progress_id UUID DEFAULT NULL, question_id UUID DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_answers JSON NOT NULL, is_correct BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5FDED4C443DB87C9 ON user_progress_track (progress_id)');
        $this->addSql('CREATE INDEX IDX_5FDED4C41E27F6BF ON user_progress_track (question_id)');
        $this->addSql('COMMENT ON COLUMN user_progress_track.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE question_with_answers ADD CONSTRAINT FK_CAD703A779066886 FOREIGN KEY (root_id) REFERENCES questionnaire_root (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_progress ADD CONSTRAINT FK_C28C164679066886 FOREIGN KEY (root_id) REFERENCES questionnaire_root (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_progress_track ADD CONSTRAINT FK_5FDED4C443DB87C9 FOREIGN KEY (progress_id) REFERENCES user_progress (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_progress_track ADD CONSTRAINT FK_5FDED4C41E27F6BF FOREIGN KEY (question_id) REFERENCES question_with_answers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE user_progress_track_id_seq CASCADE');
        $this->addSql('ALTER TABLE question_with_answers DROP CONSTRAINT FK_CAD703A779066886');
        $this->addSql('ALTER TABLE user_progress DROP CONSTRAINT FK_C28C164679066886');
        $this->addSql('ALTER TABLE user_progress_track DROP CONSTRAINT FK_5FDED4C443DB87C9');
        $this->addSql('ALTER TABLE user_progress_track DROP CONSTRAINT FK_5FDED4C41E27F6BF');
        $this->addSql('DROP TABLE question_with_answers');
        $this->addSql('DROP TABLE questionnaire_root');
        $this->addSql('DROP TABLE user_progress');
        $this->addSql('DROP TABLE user_progress_track');
    }
}
