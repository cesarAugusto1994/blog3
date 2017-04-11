<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170411095041 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sugestao (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, mensagem VARCHAR(255) NOT NULL, INDEX IDX_36179898DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sugestao ADD CONSTRAINT FK_36179898DB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE email_confirmacao CHANGE ativo_em ativo_em DATETIME DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE sugestao');
        $this->addSql('ALTER TABLE email_confirmacao CHANGE ativo_em ativo_em DATETIME NOT NULL');
    }
}
