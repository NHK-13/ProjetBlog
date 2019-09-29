<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190919193232 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mots_cles (id INT AUTO_INCREMENT NOT NULL, motcle VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, contenu LONGTEXT NOT NULL, email VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, createdat DATETIME NOT NULL, rgpd INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires_articles (commentaires_id INT NOT NULL, articles_id INT NOT NULL, INDEX IDX_4BEB186117C4B2B0 (commentaires_id), INDEX IDX_4BEB18611EBAF6CC (articles_id), PRIMARY KEY(commentaires_id, articles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, articles_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), INDEX IDX_1483A5E91EBAF6CC (articles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, createdat DATETIME NOT NULL, updatedat DATETIME NOT NULL, featuredimage VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_categories (articles_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_DE004A0E1EBAF6CC (articles_id), INDEX IDX_DE004A0EA21214B7 (categories_id), PRIMARY KEY(articles_id, categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_mots_cles (articles_id INT NOT NULL, mots_cles_id INT NOT NULL, INDEX IDX_2927AB461EBAF6CC (articles_id), INDEX IDX_2927AB46C0BE80DB (mots_cles_id), PRIMARY KEY(articles_id, mots_cles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaires_articles ADD CONSTRAINT FK_4BEB186117C4B2B0 FOREIGN KEY (commentaires_id) REFERENCES commentaires (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaires_articles ADD CONSTRAINT FK_4BEB18611EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E91EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE articles_categories ADD CONSTRAINT FK_DE004A0E1EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_categories ADD CONSTRAINT FK_DE004A0EA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_mots_cles ADD CONSTRAINT FK_2927AB461EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_mots_cles ADD CONSTRAINT FK_2927AB46C0BE80DB FOREIGN KEY (mots_cles_id) REFERENCES mots_cles (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE articles_mots_cles DROP FOREIGN KEY FK_2927AB46C0BE80DB');
        $this->addSql('ALTER TABLE commentaires_articles DROP FOREIGN KEY FK_4BEB186117C4B2B0');
        $this->addSql('ALTER TABLE commentaires_articles DROP FOREIGN KEY FK_4BEB18611EBAF6CC');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E91EBAF6CC');
        $this->addSql('ALTER TABLE articles_categories DROP FOREIGN KEY FK_DE004A0E1EBAF6CC');
        $this->addSql('ALTER TABLE articles_mots_cles DROP FOREIGN KEY FK_2927AB461EBAF6CC');
        $this->addSql('ALTER TABLE articles_categories DROP FOREIGN KEY FK_DE004A0EA21214B7');
        $this->addSql('DROP TABLE mots_cles');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE commentaires_articles');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE articles_categories');
        $this->addSql('DROP TABLE articles_mots_cles');
        $this->addSql('DROP TABLE categories');
    }
}
