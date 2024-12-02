<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241126201703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE connected_device (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, device_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, is_on TINYINT(1) NOT NULL, INDEX IDX_F097D203A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE heart_rate (id INT AUTO_INCREMENT NOT NULL, min_heart_rate INT NOT NULL, max_heart_rate INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sensor (id INT AUTO_INCREMENT NOT NULL, sensor_id VARCHAR(255) NOT NULL, is_on TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sensor_data (id INT AUTO_INCREMENT NOT NULL, sensor_id INT DEFAULT NULL, data VARCHAR(255) NOT NULL, captured_at DATETIME NOT NULL, INDEX IDX_801762CCA247991F (sensor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE temperature (id INT AUTO_INCREMENT NOT NULL, min_temperature DOUBLE PRECISION NOT NULL, max_temperature DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, age INT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE connected_device ADD CONSTRAINT FK_F097D203A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sensor_data ADD CONSTRAINT FK_801762CCA247991F FOREIGN KEY (sensor_id) REFERENCES sensor (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE connected_device DROP FOREIGN KEY FK_F097D203A76ED395');
        $this->addSql('ALTER TABLE sensor_data DROP FOREIGN KEY FK_801762CCA247991F');
        $this->addSql('DROP TABLE connected_device');
        $this->addSql('DROP TABLE heart_rate');
        $this->addSql('DROP TABLE sensor');
        $this->addSql('DROP TABLE sensor_data');
        $this->addSql('DROP TABLE temperature');
        $this->addSql('DROP TABLE user');
    }
}
