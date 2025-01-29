<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250129224345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE workout (id SERIAL NOT NULL, who_did_id INT DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_649FFB72E6F1DA64 ON workout (who_did_id)');
        $this->addSql('CREATE TABLE workout_set (id SERIAL NOT NULL, workout_id INT DEFAULT NULL, exercise_id INT NOT NULL, weight INT NOT NULL, reps INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6FDEFB94A6CCCFC9 ON workout_set (workout_id)');
        $this->addSql('CREATE INDEX IDX_6FDEFB94E934951A ON workout_set (exercise_id)');
        $this->addSql('ALTER TABLE workout ADD CONSTRAINT FK_649FFB72E6F1DA64 FOREIGN KEY (who_did_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE workout_set ADD CONSTRAINT FK_6FDEFB94A6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE workout_set ADD CONSTRAINT FK_6FDEFB94E934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE workout DROP CONSTRAINT FK_649FFB72E6F1DA64');
        $this->addSql('ALTER TABLE workout_set DROP CONSTRAINT FK_6FDEFB94A6CCCFC9');
        $this->addSql('ALTER TABLE workout_set DROP CONSTRAINT FK_6FDEFB94E934951A');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE workout');
        $this->addSql('DROP TABLE workout_set');
    }
}
