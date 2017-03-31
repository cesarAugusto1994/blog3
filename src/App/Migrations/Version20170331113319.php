<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170331113319 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE status_email (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE email_confirmacao (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, status_id INT DEFAULT NULL, token VARCHAR(50) NOT NULL, gerado_em DATETIME NOT NULL, ativo_em DATETIME NOT NULL, validade DATETIME NOT NULL, INDEX IDX_473E44A5DB38439E (usuario_id), INDEX IDX_473E44A56BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE email_confirmacao ADD CONSTRAINT FK_473E44A5DB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE email_confirmacao ADD CONSTRAINT FK_473E44A56BF700BD FOREIGN KEY (status_id) REFERENCES status_email (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE email_confirmacao DROP FOREIGN KEY FK_473E44A56BF700BD');
        $this->addSql('DROP TABLE status_email');
        $this->addSql('DROP TABLE email_confirmacao');
    }
}
