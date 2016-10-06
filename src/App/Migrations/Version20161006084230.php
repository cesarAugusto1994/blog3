<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161006084230 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE musica CHANGE numero numero INT DEFAULT NULL');
        $this->addSql('ALTER TABLE widgets ADD decricao VARCHAR(255) DEFAULT NULL, ADD url VARCHAR(255) DEFAULT NULL, ADD imagem VARCHAR(255) NOT NULL, ADD role VARCHAR(255) NOT NULL, CHANGE ativo ativo TINYINT(1) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE musica CHANGE numero numero INT DEFAULT NULL');
        $this->addSql('ALTER TABLE widgets DROP decricao, DROP url, DROP imagem, DROP role, CHANGE ativo ativo SMALLINT NOT NULL');
    }
}
