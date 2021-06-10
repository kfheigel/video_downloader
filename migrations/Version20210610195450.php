<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210610195450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url_shortener DROP FOREIGN KEY FK_6759B37A9D86650F');
        $this->addSql('ALTER TABLE url_shortener ADD CONSTRAINT FK_6759B37A9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_history DROP FOREIGN KEY FK_7FB76E419D86650F');
        $this->addSql('ALTER TABLE user_history ADD CONSTRAINT FK_7FB76E419D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url_shortener DROP FOREIGN KEY FK_6759B37A9D86650F');
        $this->addSql('ALTER TABLE url_shortener ADD CONSTRAINT FK_6759B37A9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user_history DROP FOREIGN KEY FK_7FB76E419D86650F');
        $this->addSql('ALTER TABLE user_history ADD CONSTRAINT FK_7FB76E419D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
