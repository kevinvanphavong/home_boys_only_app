<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211210135912 extends AbstractMigration
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
        $this->addSql('ALTER TABLE partygoer DROP profile_picture_name, DROP profile_picture_updated_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE profile_image');
        $this->addSql('ALTER TABLE partygoer ADD profile_picture_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD profile_picture_updated_at DATETIME DEFAULT NULL');
    }
}
