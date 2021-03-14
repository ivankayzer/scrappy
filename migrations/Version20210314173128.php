<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210314173128 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE script DROP FOREIGN KEY FK_1C81873A8DB60186');
        $this->addSql('ALTER TABLE script ADD CONSTRAINT FK_1C81873A8DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE script_output DROP FOREIGN KEY FK_AC025C64ACC77613');
        $this->addSql('ALTER TABLE script_output ADD CONSTRAINT FK_AC025C64ACC77613 FOREIGN KEY (execution_history_id) REFERENCES task_execution_history (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25A76ED395');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task_execution_history DROP FOREIGN KEY FK_A3B4FD9B8DB60186');
        $this->addSql('ALTER TABLE task_execution_history ADD CONSTRAINT FK_A3B4FD9B8DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE script DROP FOREIGN KEY FK_1C81873A8DB60186');
        $this->addSql('ALTER TABLE script ADD CONSTRAINT FK_1C81873A8DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE script_output DROP FOREIGN KEY FK_AC025C64ACC77613');
        $this->addSql('ALTER TABLE script_output ADD CONSTRAINT FK_AC025C64ACC77613 FOREIGN KEY (execution_history_id) REFERENCES task_execution_history (id)');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25A76ED395');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task_execution_history DROP FOREIGN KEY FK_A3B4FD9B8DB60186');
        $this->addSql('ALTER TABLE task_execution_history ADD CONSTRAINT FK_A3B4FD9B8DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
    }
}
