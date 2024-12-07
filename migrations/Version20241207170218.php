<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241207170218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE connected_device (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, device_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, is_on TINYINT(1) NOT NULL, INDEX IDX_F097D203A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE heart_rate (id INT NOT NULL, min_heart_rate INT NOT NULL, max_heart_rate INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE humidity (id INT NOT NULL, humidity_level DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sensor (id INT AUTO_INCREMENT NOT NULL, connected_device_id INT DEFAULT NULL, sensor_id VARCHAR(255) NOT NULL, is_on TINYINT(1) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_BC8617B0B962DAE3 (connected_device_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sensor_data (id INT AUTO_INCREMENT NOT NULL, sensor_id INT DEFAULT NULL, data VARCHAR(255) NOT NULL, captured_at DATETIME NOT NULL, INDEX IDX_801762CCA247991F (sensor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE temperature (id INT NOT NULL, min_temperature DOUBLE PRECISION NOT NULL, max_temperature DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, age INT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE connected_device ADD CONSTRAINT FK_F097D203A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE heart_rate ADD CONSTRAINT FK_84A07ED6BF396750 FOREIGN KEY (id) REFERENCES sensor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE humidity ADD CONSTRAINT FK_69FC77C2BF396750 FOREIGN KEY (id) REFERENCES sensor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sensor ADD CONSTRAINT FK_BC8617B0B962DAE3 FOREIGN KEY (connected_device_id) REFERENCES connected_device (id)');
        $this->addSql('ALTER TABLE sensor_data ADD CONSTRAINT FK_801762CCA247991F FOREIGN KEY (sensor_id) REFERENCES sensor (id)');
        $this->addSql('ALTER TABLE temperature ADD CONSTRAINT FK_BE4E2A6CBF396750 FOREIGN KEY (id) REFERENCES sensor (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE connected_device DROP FOREIGN KEY FK_F097D203A76ED395');
        $this->addSql('ALTER TABLE heart_rate DROP FOREIGN KEY FK_84A07ED6BF396750');
        $this->addSql('ALTER TABLE humidity DROP FOREIGN KEY FK_69FC77C2BF396750');
        $this->addSql('ALTER TABLE sensor DROP FOREIGN KEY FK_BC8617B0B962DAE3');
        $this->addSql('ALTER TABLE sensor_data DROP FOREIGN KEY FK_801762CCA247991F');
        $this->addSql('ALTER TABLE temperature DROP FOREIGN KEY FK_BE4E2A6CBF396750');
        $this->addSql('DROP TABLE connected_device');
        $this->addSql('DROP TABLE heart_rate');
        $this->addSql('DROP TABLE humidity');
        $this->addSql('DROP TABLE sensor');
        $this->addSql('DROP TABLE sensor_data');
        $this->addSql('DROP TABLE temperature');
        $this->addSql('DROP TABLE user');
    }
}
