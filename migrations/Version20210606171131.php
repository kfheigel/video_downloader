<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210606171131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url_shortener ADD user_id_id INT DEFAULT NULL, DROP user_id, CHANGE url_long url_long VARCHAR(1100) NOT NULL, CHANGE date created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE url_shortener ADD CONSTRAINT FK_6759B37A9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_6759B37A9D86650F ON url_shortener (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url_shortener DROP FOREIGN KEY FK_6759B37A9D86650F');
        $this->addSql('DROP INDEX IDX_6759B37A9D86650F ON url_shortener');
        $this->addSql('ALTER TABLE url_shortener ADD user_id INT NOT NULL, DROP user_id_id, CHANGE url_long url_long VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE created_at date DATETIME NOT NULL');
    }
}
