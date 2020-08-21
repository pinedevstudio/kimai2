<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200731171550 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE kimai2_tasks ADD time_budget INT DEFAULT NULL');
        $this->addSql('ALTER TABLE kimai2_tasks ADD pd_start_time DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime)\'');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE kimai2_tasks DROP time_budget');
        $this->addSql('ALTER TABLE kimai2_tasks DROP pd_start_time');

    }
}
