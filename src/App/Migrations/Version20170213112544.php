<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170213112544 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Favoritos RENAME INDEX idx_9c770adc99e6f854 TO IDX_1E86887F99E6F854');
        $this->addSql('ALTER TABLE Favoritos RENAME INDEX idx_9c770adcdb38439e TO IDX_1E86887FDB38439E');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE favoritos RENAME INDEX idx_1e86887f99e6f854 TO IDX_9C770ADC99E6F854');
        $this->addSql('ALTER TABLE favoritos RENAME INDEX idx_1e86887fdb38439e TO IDX_9C770ADCDB38439E');
    }
}
