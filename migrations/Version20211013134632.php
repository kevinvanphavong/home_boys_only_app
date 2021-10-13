<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211013134632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, event_id INT NOT NULL, content LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_9474526CF675F31B (author_id), INDEX IDX_9474526C71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, planner_id INT NOT NULL, title VARCHAR(255) NOT NULL, starting_date DATETIME NOT NULL, ending_date DATETIME NOT NULL, entrance_price INT DEFAULT NULL, country VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, end_of_registrations DATETIME NOT NULL, limited_places INT NOT NULL, presentation LONGTEXT NOT NULL, INDEX IDX_3BAE0AA75346EAE1 (planner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_cover (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, name LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_CC1337E971F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_picture (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, name LONGTEXT NOT NULL, INDEX IDX_938CE62671F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gathering_complement_included (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gathering_complement_included_event (gathering_complement_included_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_F97A5E37DD998140 (gathering_complement_included_id), INDEX IDX_F97A5E3771F7E88B (event_id), PRIMARY KEY(gathering_complement_included_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gathering_complement_to_bring (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gathering_complement_to_bring_event (gathering_complement_to_bring_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_C9E061E396EAF1E9 (gathering_complement_to_bring_id), INDEX IDX_C9E061E371F7E88B (event_id), PRIMARY KEY(gathering_complement_to_bring_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partygoer (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, phone VARCHAR(255) DEFAULT NULL, presentation LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_5696B760A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES partygoer (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA75346EAE1 FOREIGN KEY (planner_id) REFERENCES partygoer (id)');
        $this->addSql('ALTER TABLE event_cover ADD CONSTRAINT FK_CC1337E971F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE event_picture ADD CONSTRAINT FK_938CE62671F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE gathering_complement_included_event ADD CONSTRAINT FK_F97A5E37DD998140 FOREIGN KEY (gathering_complement_included_id) REFERENCES gathering_complement_included (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gathering_complement_included_event ADD CONSTRAINT FK_F97A5E3771F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gathering_complement_to_bring_event ADD CONSTRAINT FK_C9E061E396EAF1E9 FOREIGN KEY (gathering_complement_to_bring_id) REFERENCES gathering_complement_to_bring (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gathering_complement_to_bring_event ADD CONSTRAINT FK_C9E061E371F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partygoer ADD CONSTRAINT FK_5696B760A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C71F7E88B');
        $this->addSql('ALTER TABLE event_cover DROP FOREIGN KEY FK_CC1337E971F7E88B');
        $this->addSql('ALTER TABLE event_picture DROP FOREIGN KEY FK_938CE62671F7E88B');
        $this->addSql('ALTER TABLE gathering_complement_included_event DROP FOREIGN KEY FK_F97A5E3771F7E88B');
        $this->addSql('ALTER TABLE gathering_complement_to_bring_event DROP FOREIGN KEY FK_C9E061E371F7E88B');
        $this->addSql('ALTER TABLE gathering_complement_included_event DROP FOREIGN KEY FK_F97A5E37DD998140');
        $this->addSql('ALTER TABLE gathering_complement_to_bring_event DROP FOREIGN KEY FK_C9E061E396EAF1E9');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA75346EAE1');
        $this->addSql('ALTER TABLE partygoer DROP FOREIGN KEY FK_5696B760A76ED395');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_cover');
        $this->addSql('DROP TABLE event_picture');
        $this->addSql('DROP TABLE gathering_complement_included');
        $this->addSql('DROP TABLE gathering_complement_included_event');
        $this->addSql('DROP TABLE gathering_complement_to_bring');
        $this->addSql('DROP TABLE gathering_complement_to_bring_event');
        $this->addSql('DROP TABLE partygoer');
        $this->addSql('DROP TABLE user');
    }
}
