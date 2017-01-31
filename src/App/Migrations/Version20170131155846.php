<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170131155846 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Favoritos (id INT AUTO_INCREMENT NOT NULL, musica_id INT DEFAULT NULL, usuario_id INT DEFAULT NULL, cadastro DATETIME NOT NULL, INDEX IDX_9C770ADC99E6F854 (musica_id), INDEX IDX_9C770ADCDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Favoritos ADD CONSTRAINT FK_9C770ADC99E6F854 FOREIGN KEY (musica_id) REFERENCES musica (id)');
        $this->addSql('ALTER TABLE Favoritos ADD CONSTRAINT FK_9C770ADCDB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE Favoritos');
    }
}
