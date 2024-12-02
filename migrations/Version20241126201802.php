<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241126201802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE heart_rate CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE heart_rate ADD CONSTRAINT FK_84A07ED6BF396750 FOREIGN KEY (id) REFERENCES sensor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sensor ADD type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE temperature CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE temperature ADD CONSTRAINT FK_BE4E2A6CBF396750 FOREIGN KEY (id) REFERENCES sensor (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE heart_rate DROP FOREIGN KEY FK_84A07ED6BF396750');
        $this->addSql('ALTER TABLE heart_rate CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE sensor DROP type');
        $this->addSql('ALTER TABLE temperature DROP FOREIGN KEY FK_BE4E2A6CBF396750');
        $this->addSql('ALTER TABLE temperature CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
