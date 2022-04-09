<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220409110624 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE tasks (
                id INT AUTO_INCREMENT NOT NULL,
                title VARCHAR(255) NOT NULL,
                description LONGTEXT NOT NULL,
                status TINYINT(1) DEFAULT 0 NOT NULL COMMENT \'0 - todo, 1 - done\',
                created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
                updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE tasks');
    }
}
