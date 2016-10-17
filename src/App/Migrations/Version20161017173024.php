<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161017173024 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE post_tags');
        $this->addSql('ALTER TABLE comentarios ADD musica_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comentarios ADD CONSTRAINT FK_F54B3FC099E6F854 FOREIGN KEY (musica_id) REFERENCES musica (id)');
        $this->addSql('CREATE INDEX IDX_F54B3FC099E6F854 ON comentarios (musica_id)');
        $this->addSql('ALTER TABLE musica_anexos CHANGE link link LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE musica CHANGE numero numero INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE post_tags (post_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_A6E9F32D4B89032C (post_id), INDEX IDX_A6E9F32DBAD26311 (tag_id), PRIMARY KEY(post_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_tags ADD CONSTRAINT FK_A6E9F32D4B89032C FOREIGN KEY (post_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE post_tags ADD CONSTRAINT FK_A6E9F32DBAD26311 FOREIGN KEY (tag_id) REFERENCES tags (id)');
        $this->addSql('ALTER TABLE comentarios DROP FOREIGN KEY FK_F54B3FC099E6F854');
        $this->addSql('DROP INDEX IDX_F54B3FC099E6F854 ON comentarios');
        $this->addSql('ALTER TABLE comentarios DROP musica_id');
        $this->addSql('ALTER TABLE musica CHANGE numero numero INT DEFAULT NULL');
        $this->addSql('ALTER TABLE musica_anexos CHANGE link link LONGTEXT NOT NULL COLLATE utf8_unicode_ci');
    }
}
