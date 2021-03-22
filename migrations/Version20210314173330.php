<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210314173330 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE script_output DROP FOREIGN KEY FK_AC025C64A1C01850');
        $this->addSql('ALTER TABLE script_output CHANGE script_id script_id INT NOT NULL');
        $this->addSql('ALTER TABLE script_output ADD CONSTRAINT FK_AC025C64A1C01850 FOREIGN KEY (script_id) REFERENCES script (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE script_output DROP FOREIGN KEY FK_AC025C64A1C01850');
        $this->addSql('ALTER TABLE script_output CHANGE script_id script_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE script_output ADD CONSTRAINT FK_AC025C64A1C01850 FOREIGN KEY (script_id) REFERENCES script (id)');
    }
}
