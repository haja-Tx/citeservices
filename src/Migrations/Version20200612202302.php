<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200612202302 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE facture_connection (facture_id INT NOT NULL, connection_id INT NOT NULL, INDEX IDX_C3E89C627F2DEE08 (facture_id), INDEX IDX_C3E89C62DD03F01 (connection_id), PRIMARY KEY(facture_id, connection_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture_connection ADD CONSTRAINT FK_C3E89C627F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE facture_connection ADD CONSTRAINT FK_C3E89C62DD03F01 FOREIGN KEY (connection_id) REFERENCES connection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE connection ADD factures VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE notification CHANGE level level VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE facture_connection');
        $this->addSql('ALTER TABLE connection DROP factures');
        $this->addSql('ALTER TABLE notification CHANGE level level VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
