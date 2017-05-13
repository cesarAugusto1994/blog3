<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170513093641 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE anexo_downloads (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, anexo_id INT DEFAULT NULL, INDEX IDX_7C83D622DB38439E (usuario_id), INDEX IDX_7C83D622C9348664 (anexo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grupo_usuarios (id INT AUTO_INCREMENT NOT NULL, grupo_id INT DEFAULT NULL, usuario_id INT DEFAULT NULL, INDEX IDX_461BB8379C833003 (grupo_id), INDEX IDX_461BB837DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sugestao_resposta (id INT AUTO_INCREMENT NOT NULL, sugestao_id INT DEFAULT NULL, usuario_id INT DEFAULT NULL, mensagem VARCHAR(255) NOT NULL, enviada_em DATETIME DEFAULT NULL, INDEX IDX_B11B25F4AF0AA99B (sugestao_id), INDEX IDX_B11B25F4DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sugestao (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, mensagem VARCHAR(255) NOT NULL, enviada_em DATETIME DEFAULT NULL, respondida TINYINT(1) NOT NULL, INDEX IDX_36179898DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grupo (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, cidade VARCHAR(255) NOT NULL, uf VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grupo_musicas (id INT AUTO_INCREMENT NOT NULL, grupo_id INT DEFAULT NULL, musica_id INT DEFAULT NULL, INDEX IDX_74CCCD019C833003 (grupo_id), INDEX IDX_74CCCD0199E6F854 (musica_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emails_enviados (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, mensagem LONGTEXT NOT NULL, data_hora DATETIME NOT NULL, tipo VARCHAR(255) NOT NULL, INDEX IDX_FC7E208FDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE login (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, data_login DATETIME NOT NULL, data_logout DATETIME DEFAULT NULL, sessao VARCHAR(50) NOT NULL, INDEX IDX_AA08CB10DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cidades (id INT AUTO_INCREMENT NOT NULL, codigo INT NOT NULL, nome VARCHAR(255) NOT NULL, uf SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist_musicas (id INT AUTO_INCREMENT NOT NULL, playlist_id INT DEFAULT NULL, musica_id INT DEFAULT NULL, usuario_id INT DEFAULT NULL, cadastro DATETIME NOT NULL, INDEX IDX_94FA54BC6BBD148 (playlist_id), INDEX IDX_94FA54BC99E6F854 (musica_id), INDEX IDX_94FA54BCDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, nome VARCHAR(255) NOT NULL, cadastro DATETIME NOT NULL, INDEX IDX_D782112DDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE anexo_downloads ADD CONSTRAINT FK_7C83D622DB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE anexo_downloads ADD CONSTRAINT FK_7C83D622C9348664 FOREIGN KEY (anexo_id) REFERENCES musica_anexos (id)');
        $this->addSql('ALTER TABLE grupo_usuarios ADD CONSTRAINT FK_461BB8379C833003 FOREIGN KEY (grupo_id) REFERENCES grupo (id)');
        $this->addSql('ALTER TABLE grupo_usuarios ADD CONSTRAINT FK_461BB837DB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE sugestao_resposta ADD CONSTRAINT FK_B11B25F4AF0AA99B FOREIGN KEY (sugestao_id) REFERENCES sugestao (id)');
        $this->addSql('ALTER TABLE sugestao_resposta ADD CONSTRAINT FK_B11B25F4DB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE sugestao ADD CONSTRAINT FK_36179898DB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE grupo_musicas ADD CONSTRAINT FK_74CCCD019C833003 FOREIGN KEY (grupo_id) REFERENCES grupo (id)');
        $this->addSql('ALTER TABLE grupo_musicas ADD CONSTRAINT FK_74CCCD0199E6F854 FOREIGN KEY (musica_id) REFERENCES musica (id)');
        $this->addSql('ALTER TABLE emails_enviados ADD CONSTRAINT FK_FC7E208FDB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE login ADD CONSTRAINT FK_AA08CB10DB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE playlist_musicas ADD CONSTRAINT FK_94FA54BC6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)');
        $this->addSql('ALTER TABLE playlist_musicas ADD CONSTRAINT FK_94FA54BC99E6F854 FOREIGN KEY (musica_id) REFERENCES musica_anexos (id)');
        $this->addSql('ALTER TABLE playlist_musicas ADD CONSTRAINT FK_94FA54BCDB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112DDB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE categoria ADD apenas_anexos TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE email_confirmacao CHANGE ativo_em ativo_em DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE musica ADD apenas_anexos TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE usuarios ADD grupo_id INT DEFAULT NULL, ADD cidade VARCHAR(255) NOT NULL, ADD uf VARCHAR(50) NOT NULL, ADD senha VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE usuarios ADD CONSTRAINT FK_EF687F29C833003 FOREIGN KEY (grupo_id) REFERENCES grupo (id)');
        $this->addSql('CREATE INDEX IDX_EF687F29C833003 ON usuarios (grupo_id)');
        $this->addSql('ALTER TABLE config ADD about LONGTEXT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sugestao_resposta DROP FOREIGN KEY FK_B11B25F4AF0AA99B');
        $this->addSql('ALTER TABLE grupo_usuarios DROP FOREIGN KEY FK_461BB8379C833003');
        $this->addSql('ALTER TABLE grupo_musicas DROP FOREIGN KEY FK_74CCCD019C833003');
        $this->addSql('ALTER TABLE usuarios DROP FOREIGN KEY FK_EF687F29C833003');
        $this->addSql('ALTER TABLE playlist_musicas DROP FOREIGN KEY FK_94FA54BC6BBD148');
        $this->addSql('DROP TABLE anexo_downloads');
        $this->addSql('DROP TABLE grupo_usuarios');
        $this->addSql('DROP TABLE sugestao_resposta');
        $this->addSql('DROP TABLE sugestao');
        $this->addSql('DROP TABLE grupo');
        $this->addSql('DROP TABLE grupo_musicas');
        $this->addSql('DROP TABLE emails_enviados');
        $this->addSql('DROP TABLE login');
        $this->addSql('DROP TABLE cidades');
        $this->addSql('DROP TABLE playlist_musicas');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('ALTER TABLE categoria DROP apenas_anexos');
        $this->addSql('ALTER TABLE config DROP about');
        $this->addSql('ALTER TABLE email_confirmacao CHANGE ativo_em ativo_em DATETIME NOT NULL');
        $this->addSql('ALTER TABLE musica DROP apenas_anexos');
        $this->addSql('DROP INDEX IDX_EF687F29C833003 ON usuarios');
        $this->addSql('ALTER TABLE usuarios DROP grupo_id, DROP cidade, DROP uf, DROP senha');
    }
}
