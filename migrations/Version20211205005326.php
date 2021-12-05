<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211205005326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partygoer_event (partygoer_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_EB9FD11F9C7E0048 (partygoer_id), INDEX IDX_EB9FD11F71F7E88B (event_id), PRIMARY KEY(partygoer_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partygoer_event ADD CONSTRAINT FK_EB9FD11F9C7E0048 FOREIGN KEY (partygoer_id) REFERENCES partygoer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partygoer_event ADD CONSTRAINT FK_EB9FD11F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE favlist');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favlist (id INT AUTO_INCREMENT NOT NULL, partygoer_id INT NOT NULL, events_id INT DEFAULT NULL, INDEX IDX_A5BC48359D6A1065 (events_id), UNIQUE INDEX UNIQ_A5BC48359C7E0048 (partygoer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE favlist ADD CONSTRAINT FK_A5BC48359C7E0048 FOREIGN KEY (partygoer_id) REFERENCES partygoer (id)');
        $this->addSql('ALTER TABLE favlist ADD CONSTRAINT FK_A5BC48359D6A1065 FOREIGN KEY (events_id) REFERENCES event (id)');
        $this->addSql('DROP TABLE partygoer_event');
    }
}
