<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210106142653 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE allergen (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE allergen_dish (allergen_id INTEGER NOT NULL, dish_id INTEGER NOT NULL, PRIMARY KEY(allergen_id, dish_id))');
        $this->addSql('CREATE INDEX IDX_7D38EB3C6E775A4A ON allergen_dish (allergen_id)');
        $this->addSql('CREATE INDEX IDX_7D38EB3C148EB0CB ON allergen_dish (dish_id)');
        $this->addSql('DROP INDEX IDX_957D8CB8A76ED395');
        $this->addSql('DROP INDEX IDX_957D8CB812469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__dish AS SELECT id, category_id, user_id, name, calories, price, image, description, sticky FROM dish');
        $this->addSql('DROP TABLE dish');
        $this->addSql('CREATE TABLE dish (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, calories INTEGER NOT NULL, price DOUBLE PRECISION NOT NULL, image VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, sticky BOOLEAN NOT NULL, CONSTRAINT FK_957D8CB812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_957D8CB8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO dish (id, category_id, user_id, name, calories, price, image, description, sticky) SELECT id, category_id, user_id, name, calories, price, image, description, sticky FROM __temp__dish');
        $this->addSql('DROP TABLE __temp__dish');
        $this->addSql('CREATE INDEX IDX_957D8CB8A76ED395 ON dish (user_id)');
        $this->addSql('CREATE INDEX IDX_957D8CB812469DE2 ON dish (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE allergen');
        $this->addSql('DROP TABLE allergen_dish');
        $this->addSql('DROP INDEX IDX_957D8CB812469DE2');
        $this->addSql('DROP INDEX IDX_957D8CB8A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__dish AS SELECT id, category_id, user_id, name, calories, price, image, description, sticky FROM dish');
        $this->addSql('DROP TABLE dish');
        $this->addSql('CREATE TABLE dish (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, calories INTEGER NOT NULL, price DOUBLE PRECISION NOT NULL, image VARCHAR(255) NOT NULL, description CLOB NOT NULL, sticky BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO dish (id, category_id, user_id, name, calories, price, image, description, sticky) SELECT id, category_id, user_id, name, calories, price, image, description, sticky FROM __temp__dish');
        $this->addSql('DROP TABLE __temp__dish');
        $this->addSql('CREATE INDEX IDX_957D8CB812469DE2 ON dish (category_id)');
        $this->addSql('CREATE INDEX IDX_957D8CB8A76ED395 ON dish (user_id)');
    }
}
