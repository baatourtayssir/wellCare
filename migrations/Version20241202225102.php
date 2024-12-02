<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241202225102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE humidity (id INT NOT NULL, humidity_level DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE humidity ADD CONSTRAINT FK_69FC77C2BF396750 FOREIGN KEY (id) REFERENCES sensor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE connected_device CHANGE user_id user_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE humidity DROP FOREIGN KEY FK_69FC77C2BF396750');
        $this->addSql('DROP TABLE humidity');
        $this->addSql('ALTER TABLE connected_device CHANGE user_id user_id INT NOT NULL');
    }
}
