<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211218000734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profile_image (id INT AUTO_INCREMENT NOT NULL, partygoer_id INT NOT NULL, name LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_32E99B8D9C7E0048 (partygoer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profile_image ADD CONSTRAINT FK_32E99B8D9C7E0048 FOREIGN KEY (partygoer_id) REFERENCES partygoer (id)');
        $this->addSql('ALTER TABLE comment ADD visible TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD visible TINYINT(1) DEFAULT NULL, ADD canceled TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE notification ADD event_id INT NOT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_BF5476CA71F7E88B ON notification (event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE profile_image');
        $this->addSql('ALTER TABLE comment DROP visible');
        $this->addSql('ALTER TABLE event DROP visible, DROP canceled');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA71F7E88B');
        $this->addSql('DROP INDEX IDX_BF5476CA71F7E88B ON notification');
        $this->addSql('ALTER TABLE notification DROP event_id');
    }
}
