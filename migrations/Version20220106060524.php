<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220106060524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, total DOUBLE PRECISION DEFAULT NULL, discount DOUBLE PRECISION DEFAULT NULL, state VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F52993989395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, order_details_id INT DEFAULT NULL, name VARCHAR(150) DEFAULT NULL, amount DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D34A04AD8C0FA77 (order_details_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shipping_details (id INT AUTO_INCREMENT NOT NULL, order_details_id INT DEFAULT NULL, method VARCHAR(100) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, postcode INT NOT NULL, phone_number VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_946E0D4E8C0FA77 (order_details_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD8C0FA77 FOREIGN KEY (order_details_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE shipping_details ADD CONSTRAINT FK_946E0D4E8C0FA77 FOREIGN KEY (order_details_id) REFERENCES `order` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD8C0FA77');
        $this->addSql('ALTER TABLE shipping_details DROP FOREIGN KEY FK_946E0D4E8C0FA77');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE shipping_details');
    }
}
