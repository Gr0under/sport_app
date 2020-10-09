<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200909085430 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event_wall_message (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, event_id INT NOT NULL, message LONGTEXT NOT NULL, pin TINYINT(1) NOT NULL, INDEX IDX_8115753AF675F31B (author_id), INDEX IDX_8115753A71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_wall_message ADD CONSTRAINT FK_8115753AF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event_wall_message ADD CONSTRAINT FK_8115753A71F7E88B FOREIGN KEY (event_id) REFERENCES sport_event (id)');
        $this->addSql('ALTER TABLE sport_event CHANGE material material LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE other_attributes other_attributes LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE full_name full_name VARCHAR(255) DEFAULT NULL, CHANGE pseudo pseudo VARCHAR(255) DEFAULT NULL, CHANGE birthdate birthdate DATE DEFAULT NULL, CHANGE address address INT DEFAULT NULL, CHANGE gender gender VARCHAR(255) DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE event_wall_message');
        $this->addSql('ALTER TABLE sport_event CHANGE material material LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE other_attributes other_attributes LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE full_name full_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE pseudo pseudo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE birthdate birthdate DATE DEFAULT \'NULL\', CHANGE address address INT DEFAULT NULL, CHANGE gender gender VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE picture picture VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
