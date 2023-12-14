<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214090929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, google_book_id VARCHAR(255) NOT NULL, title LONGTEXT NOT NULL, sub_title LONGTEXT DEFAULT NULL, published_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', description LONGTEXT DEFAULT NULL, isbn10 VARCHAR(255) DEFAULT NULL, isbn13 VARCHAR(255) DEFAULT NULL, page_count INT DEFAULT NULL, small_thumbnail VARCHAR(255) DEFAULT NULL, thumbnail VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_auteur (book_id INT NOT NULL, auteur_id INT NOT NULL, INDEX IDX_2C8DBACD16A2B381 (book_id), INDEX IDX_2C8DBACD60BB6FE6 (auteur_id), PRIMARY KEY(book_id, auteur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_publisher (book_id INT NOT NULL, publisher_id INT NOT NULL, INDEX IDX_8E46C30016A2B381 (book_id), INDEX IDX_8E46C30040C86FCE (publisher_id), PRIMARY KEY(book_id, publisher_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_book (id INT AUTO_INCREMENT NOT NULL, reader_id INT DEFAULT NULL, book_id INT DEFAULT NULL, status_id INT DEFAULT NULL, comment LONGTEXT DEFAULT NULL, rating INT DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B164EFF81717D737 (reader_id), INDEX IDX_B164EFF816A2B381 (book_id), INDEX IDX_B164EFF86BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_auteur ADD CONSTRAINT FK_2C8DBACD16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_auteur ADD CONSTRAINT FK_2C8DBACD60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES google_auteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_publisher ADD CONSTRAINT FK_8E46C30016A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_publisher ADD CONSTRAINT FK_8E46C30040C86FCE FOREIGN KEY (publisher_id) REFERENCES google_publisher (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_book ADD CONSTRAINT FK_B164EFF81717D737 FOREIGN KEY (reader_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_book ADD CONSTRAINT FK_B164EFF816A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE user_book ADD CONSTRAINT FK_B164EFF86BF700BD FOREIGN KEY (status_id) REFERENCES google_status (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_auteur DROP FOREIGN KEY FK_2C8DBACD16A2B381');
        $this->addSql('ALTER TABLE book_auteur DROP FOREIGN KEY FK_2C8DBACD60BB6FE6');
        $this->addSql('ALTER TABLE book_publisher DROP FOREIGN KEY FK_8E46C30016A2B381');
        $this->addSql('ALTER TABLE book_publisher DROP FOREIGN KEY FK_8E46C30040C86FCE');
        $this->addSql('ALTER TABLE user_book DROP FOREIGN KEY FK_B164EFF81717D737');
        $this->addSql('ALTER TABLE user_book DROP FOREIGN KEY FK_B164EFF816A2B381');
        $this->addSql('ALTER TABLE user_book DROP FOREIGN KEY FK_B164EFF86BF700BD');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_auteur');
        $this->addSql('DROP TABLE book_publisher');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_book');
    }
}
