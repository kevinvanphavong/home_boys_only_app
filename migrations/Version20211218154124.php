<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211218154124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invitation (id INT AUTO_INCREMENT NOT NULL, partygoer_guest_id INT NOT NULL, partygoer_event_planner_id INT NOT NULL, event_id INT NOT NULL, is_request TINYINT(1) NOT NULL, is_making TINYINT(1) NOT NULL, date DATETIME NOT NULL, last_modified DATETIME NOT NULL, content LONGTEXT NOT NULL, is_accepted TINYINT(1) DEFAULT NULL, INDEX IDX_F11D61A2621515CE (partygoer_guest_id), INDEX IDX_F11D61A276467A3B (partygoer_event_planner_id), INDEX IDX_F11D61A271F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2621515CE FOREIGN KEY (partygoer_guest_id) REFERENCES partygoer (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A276467A3B FOREIGN KEY (partygoer_event_planner_id) REFERENCES partygoer (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A271F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE invitation');
    }
}
