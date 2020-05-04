<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200504093831 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sport_event (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, organiser VARCHAR(255) NOT NULL, date DATETIME NOT NULL, time DATETIME NOT NULL, location_dpt VARCHAR(255) NOT NULL, location_city VARCHAR(255) NOT NULL, location_address LONGTEXT NOT NULL, thumbnail VARCHAR(255) NOT NULL, player VARCHAR(255) NOT NULL, level VARCHAR(255) NOT NULL, level_description LONGTEXT NOT NULL, material LONGTEXT NOT NULL, assembly_point LONGTEXT NOT NULL, price_description LONGTEXT NOT NULL, distance VARCHAR(255) DEFAULT NULL, pace VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE sport_event');
    }
}
