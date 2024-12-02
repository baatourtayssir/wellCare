<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241127225828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sensor ADD connected_device_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sensor ADD CONSTRAINT FK_BC8617B0B962DAE3 FOREIGN KEY (connected_device_id) REFERENCES connected_device (id)');
        $this->addSql('CREATE INDEX IDX_BC8617B0B962DAE3 ON sensor (connected_device_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sensor DROP FOREIGN KEY FK_BC8617B0B962DAE3');
        $this->addSql('DROP INDEX IDX_BC8617B0B962DAE3 ON sensor');
        $this->addSql('ALTER TABLE sensor DROP connected_device_id');
    }
}
