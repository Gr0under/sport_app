<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200506082643 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sport_category ADD thumbnail_collection LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE sport_event CHANGE distance distance VARCHAR(255) DEFAULT NULL, CHANGE pace pace VARCHAR(255) DEFAULT NULL');
     
        $this->addSql('CREATE INDEX IDX_8FD26BBE7173D9A4 ON sport_event (sport_category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sport_category DROP thumbnail_collection');
        $this->addSql('ALTER TABLE sport_event DROP FOREIGN KEY FK_8FD26BBE7173D9A4');
        $this->addSql('DROP INDEX IDX_8FD26BBE7173D9A4 ON sport_event');
        $this->addSql('ALTER TABLE sport_event CHANGE distance distance VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE pace pace VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
