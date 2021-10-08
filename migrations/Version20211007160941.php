<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211007160941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gathering_complement_event DROP FOREIGN KEY FK_58F928D5AB03C75F');
        $this->addSql('CREATE TABLE gathering_complement_included (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gathering_complement_included_event (gathering_complement_included_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_F97A5E37DD998140 (gathering_complement_included_id), INDEX IDX_F97A5E3771F7E88B (event_id), PRIMARY KEY(gathering_complement_included_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gathering_complement_included_event ADD CONSTRAINT FK_F97A5E37DD998140 FOREIGN KEY (gathering_complement_included_id) REFERENCES gathering_complement_included (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gathering_complement_included_event ADD CONSTRAINT FK_F97A5E3771F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE gathering_complement');
        $this->addSql('DROP TABLE gathering_complement_event');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gathering_complement_included_event DROP FOREIGN KEY FK_F97A5E37DD998140');
        $this->addSql('CREATE TABLE gathering_complement (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, icon VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE gathering_complement_event (gathering_complement_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_58F928D5AB03C75F (gathering_complement_id), INDEX IDX_58F928D571F7E88B (event_id), PRIMARY KEY(gathering_complement_id, event_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE gathering_complement_event ADD CONSTRAINT FK_58F928D571F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gathering_complement_event ADD CONSTRAINT FK_58F928D5AB03C75F FOREIGN KEY (gathering_complement_id) REFERENCES gathering_complement (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE gathering_complement_included');
        $this->addSql('DROP TABLE gathering_complement_included_event');
    }
}
