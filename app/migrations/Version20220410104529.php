<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220410104529 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE subtasks (
                task_id INT NOT NULL,
                sub_task_id INT NOT NULL,
                INDEX IDX_2AEB8A4D8DB60186 (task_id),
                INDEX IDX_2AEB8A4DF26E5D72 (sub_task_id),
                PRIMARY KEY(task_id, sub_task_id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            ALTER TABLE subtasks ADD 
                CONSTRAINT FK_2AEB8A4D8DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id)
        ');
        $this->addSql('
            ALTER TABLE subtasks ADD
                CONSTRAINT FK_2AEB8A4DF26E5D72 FOREIGN KEY (sub_task_id) REFERENCES tasks (id)
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE subtasks');
    }
}
