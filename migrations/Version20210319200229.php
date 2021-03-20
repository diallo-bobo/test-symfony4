<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210319200229 extends AbstractMigration
{
   public function getDescription(): string
   {
      return '';
   }

   public function up(Schema $schema): void
   {
      // this up() migration is auto-generated, please modify it to your needs
      $this->addSql('CREATE TABLE property (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, surface INTEGER NOT NULL, rooms INTEGER NOT NULL, bedrooms INTEGER NOT NULL, floor INTEGER NOT NULL, price INTEGER NOT NULL, heat INTEGER NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, sold BOOLEAN DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL)');
   }

   public function down(Schema $schema): void
   {
      // this down() migration is auto-generated, please modify it to your needs
      $this->addSql('DROP TABLE property');
   }
}
