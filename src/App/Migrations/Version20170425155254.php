<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170425155254 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sugestao_resposta (id INT AUTO_INCREMENT NOT NULL, sugestao_id INT DEFAULT NULL, usuario_id INT DEFAULT NULL, mensagem VARCHAR(255) NOT NULL, enviada_em DATETIME DEFAULT NULL, INDEX IDX_B11B25F4AF0AA99B (sugestao_id), INDEX IDX_B11B25F4DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sugestao (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, mensagem VARCHAR(255) NOT NULL, enviada_em DATETIME DEFAULT NULL, respondida TINYINT(1) NOT NULL, INDEX IDX_36179898DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grupo (id INT AUTO_INCREMENT NOT NULL, cidade INT DEFAULT NULL, nome VARCHAR(255) NOT NULL, INDEX IDX_8C0E9BD36A98335C (cidade), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emails_enviados (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, mensagem LONGTEXT NOT NULL, data_hora DATETIME NOT NULL, tipo VARCHAR(255) NOT NULL, INDEX IDX_FC7E208FDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE login (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, data_login DATETIME NOT NULL, data_logout DATETIME DEFAULT NULL, sessao VARCHAR(50) NOT NULL, INDEX IDX_AA08CB10DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cidades (id INT AUTO_INCREMENT NOT NULL, codigo INT NOT NULL, nome VARCHAR(255) NOT NULL, uf SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sugestao_resposta ADD CONSTRAINT FK_B11B25F4AF0AA99B FOREIGN KEY (sugestao_id) REFERENCES sugestao (id)');
        $this->addSql('ALTER TABLE sugestao_resposta ADD CONSTRAINT FK_B11B25F4DB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE sugestao ADD CONSTRAINT FK_36179898DB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE grupo ADD CONSTRAINT FK_8C0E9BD36A98335C FOREIGN KEY (cidade) REFERENCES cidades (id)');
        $this->addSql('ALTER TABLE emails_enviados ADD CONSTRAINT FK_FC7E208FDB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE login ADD CONSTRAINT FK_AA08CB10DB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE categoria ADD apenas_anexos TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE email_confirmacao CHANGE ativo_em ativo_em DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE musica ADD apenas_anexos TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE usuarios ADD cidade VARCHAR(255) NOT NULL, ADD uf SMALLINT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sugestao_resposta DROP FOREIGN KEY FK_B11B25F4AF0AA99B');
        $this->addSql('ALTER TABLE grupo DROP FOREIGN KEY FK_8C0E9BD36A98335C');
        $this->addSql('DROP TABLE sugestao_resposta');
        $this->addSql('DROP TABLE sugestao');
        $this->addSql('DROP TABLE grupo');
        $this->addSql('DROP TABLE emails_enviados');
        $this->addSql('DROP TABLE login');
        $this->addSql('DROP TABLE cidades');
        $this->addSql('ALTER TABLE categoria DROP apenas_anexos');
        $this->addSql('ALTER TABLE email_confirmacao CHANGE ativo_em ativo_em DATETIME NOT NULL');
        $this->addSql('ALTER TABLE musica DROP apenas_anexos');
        $this->addSql('ALTER TABLE usuarios DROP cidade, DROP uf');
    }
}
