<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220410121554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE tasks ADD user_id INT NOT NULL');
        $this->addSql('
            ALTER TABLE tasks 
                ADD CONSTRAINT FK_50586597A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_50586597A76ED395');
        $this->addSql('ALTER TABLE tasks DROP user_id');
    }
}
