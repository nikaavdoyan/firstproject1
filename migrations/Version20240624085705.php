<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624085705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipeet (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, time INT NOT NULL, nbpeople INT DEFAULT NULL, difficulty INT DEFAULT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION DEFAULT NULL, isfavorite TINYINT(1) NOT NULL, createdat DATETIME NOT NULL, updatedate DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipeet_ingredient (recipeet_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_48D79906C8930E0D (recipeet_id), INDEX IDX_48D79906933FE08C (ingredient_id), PRIMARY KEY(recipeet_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipeet_ingredient ADD CONSTRAINT FK_48D79906C8930E0D FOREIGN KEY (recipeet_id) REFERENCES recipeet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipeet_ingredient ADD CONSTRAINT FK_48D79906933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipeet_ingredient DROP FOREIGN KEY FK_48D79906C8930E0D');
        $this->addSql('ALTER TABLE recipeet_ingredient DROP FOREIGN KEY FK_48D79906933FE08C');
        $this->addSql('DROP TABLE recipeet');
        $this->addSql('DROP TABLE recipeet_ingredient');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE ingredient CHANGE created_at created_at VARCHAR(255) NOT NULL');
    }
}
