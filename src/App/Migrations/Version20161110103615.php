<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161110103615 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E4399E6F854');
        $this->addSql('DROP INDEX IDX_39986E4399E6F854 ON album');
        $this->addSql('ALTER TABLE album DROP musica_id');
        $this->addSql('ALTER TABLE musica ADD album_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE musica ADD CONSTRAINT FK_7E7344EF1137ABCF FOREIGN KEY (album_id) REFERENCES musica (id)');
        $this->addSql('CREATE INDEX IDX_7E7344EF1137ABCF ON musica (album_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE album ADD musica_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E4399E6F854 FOREIGN KEY (musica_id) REFERENCES musica (id)');
        $this->addSql('CREATE INDEX IDX_39986E4399E6F854 ON album (musica_id)');
        $this->addSql('ALTER TABLE musica DROP FOREIGN KEY FK_7E7344EF1137ABCF');
        $this->addSql('DROP INDEX IDX_7E7344EF1137ABCF ON musica');
        $this->addSql('ALTER TABLE musica DROP album_id');
    }
}
