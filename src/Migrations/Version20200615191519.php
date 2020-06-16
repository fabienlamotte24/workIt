<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200615191519 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client CHANGE phase_client_id phase_client_id INT DEFAULT NULL, CHANGE age age INT DEFAULT NULL, CHANGE telephone telephone VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE email ADD destinataire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE email ADD CONSTRAINT FK_E7927C74A4F84F6E FOREIGN KEY (destinataire_id) REFERENCES client (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E7927C74A4F84F6E ON email (destinataire_id)');
        $this->addSql('ALTER TABLE template_email DROP FOREIGN KEY FK_D444AFBBA832C1C9');
        $this->addSql('DROP INDEX UNIQ_D444AFBBA832C1C9 ON template_email');
        $this->addSql('ALTER TABLE template_email ADD subject VARCHAR(255) NOT NULL, ADD body LONGTEXT NOT NULL, DROP email_id, CHANGE categorie_id categorie_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client CHANGE phase_client_id phase_client_id INT DEFAULT NULL, CHANGE age age INT DEFAULT NULL, CHANGE telephone telephone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE email DROP FOREIGN KEY FK_E7927C74A4F84F6E');
        $this->addSql('DROP INDEX UNIQ_E7927C74A4F84F6E ON email');
        $this->addSql('ALTER TABLE email DROP destinataire_id');
        $this->addSql('ALTER TABLE template_email ADD email_id INT DEFAULT NULL, DROP subject, DROP body, CHANGE categorie_id categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE template_email ADD CONSTRAINT FK_D444AFBBA832C1C9 FOREIGN KEY (email_id) REFERENCES email (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D444AFBBA832C1C9 ON template_email (email_id)');
    }
}
