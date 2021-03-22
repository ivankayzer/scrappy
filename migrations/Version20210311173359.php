<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210311173359 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE script_output (id INT AUTO_INCREMENT NOT NULL, script_id INT DEFAULT NULL, execution_history_id INT NOT NULL, output LONGTEXT DEFAULT NULL, INDEX IDX_AC025C64A1C01850 (script_id), INDEX IDX_AC025C64ACC77613 (execution_history_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_execution_history (id INT AUTO_INCREMENT NOT NULL, task_id INT NOT NULL, executed_at DATETIME NOT NULL, INDEX IDX_A3B4FD9B8DB60186 (task_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE script_output ADD CONSTRAINT FK_AC025C64A1C01850 FOREIGN KEY (script_id) REFERENCES script (id)');
        $this->addSql('ALTER TABLE script_output ADD CONSTRAINT FK_AC025C64ACC77613 FOREIGN KEY (execution_history_id) REFERENCES task_execution_history (id)');
        $this->addSql('ALTER TABLE task_execution_history ADD CONSTRAINT FK_A3B4FD9B8DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE task CHANGE status status INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE script_output DROP FOREIGN KEY FK_AC025C64ACC77613');
        $this->addSql('DROP TABLE script_output');
        $this->addSql('DROP TABLE task_execution_history');
        $this->addSql('ALTER TABLE task CHANGE status status TINYINT(1) NOT NULL');
    }
}
