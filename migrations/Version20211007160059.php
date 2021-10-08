<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211007160059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gathering_complement_to_bring (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gathering_complement_to_bring_event (gathering_complement_to_bring_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_C9E061E396EAF1E9 (gathering_complement_to_bring_id), INDEX IDX_C9E061E371F7E88B (event_id), PRIMARY KEY(gathering_complement_to_bring_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gathering_complement_to_bring_event ADD CONSTRAINT FK_C9E061E396EAF1E9 FOREIGN KEY (gathering_complement_to_bring_id) REFERENCES gathering_complement_to_bring (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gathering_complement_to_bring_event ADD CONSTRAINT FK_C9E061E371F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gathering_complement_to_bring_event DROP FOREIGN KEY FK_C9E061E396EAF1E9');
        $this->addSql('DROP TABLE gathering_complement_to_bring');
        $this->addSql('DROP TABLE gathering_complement_to_bring_event');
    }
}
