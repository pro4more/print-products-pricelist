<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200604080301 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Initial migration to set up all the tables.';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE material (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pricelist_entry (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, format_id INT NOT NULL, material_id INT NOT NULL, pages INT NOT NULL, copies INT NOT NULL, price INT NOT NULL, time_to_produce INT NOT NULL, INDEX IDX_3C9F9B924584665A (product_id), INDEX IDX_3C9F9B92D629F605 (format_id), INDEX IDX_3C9F9B92E308AC6F (material_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE available_format (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, width INT NOT NULL, height INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pricelist_entry ADD CONSTRAINT FK_3C9F9B924584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE pricelist_entry ADD CONSTRAINT FK_3C9F9B92D629F605 FOREIGN KEY (format_id) REFERENCES available_format (id)');
        $this->addSql('ALTER TABLE pricelist_entry ADD CONSTRAINT FK_3C9F9B92E308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
    }

    public function down(Schema $schema) : void
    {
        // Currently there is only one way. Forward.
    }
}
