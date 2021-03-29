<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210329211428 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `table` (id INT AUTO_INCREMENT NOT NULL, nombre_table INT NOT NULL, capacite INT NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD tables_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64985405FD2 FOREIGN KEY (tables_id) REFERENCES `table` (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64985405FD2 ON user (tables_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64985405FD2');
        $this->addSql('DROP TABLE `table`');
        $this->addSql('DROP INDEX IDX_8D93D64985405FD2 ON user');
        $this->addSql('ALTER TABLE user DROP tables_id');
    }
}
