<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161110103848 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE musica DROP FOREIGN KEY FK_7E7344EF1137ABCF');
        $this->addSql('ALTER TABLE musica ADD CONSTRAINT FK_7E7344EF1137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE musica DROP FOREIGN KEY FK_7E7344EF1137ABCF');
        $this->addSql('ALTER TABLE musica ADD CONSTRAINT FK_7E7344EF1137ABCF FOREIGN KEY (album_id) REFERENCES musica (id)');
    }
}
