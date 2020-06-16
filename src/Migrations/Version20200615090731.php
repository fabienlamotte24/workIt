<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200615090731 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie_email (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE email (id INT AUTO_INCREMENT NOT NULL, subject VARCHAR(255) NOT NULL, body LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE template_email (id INT AUTO_INCREMENT NOT NULL, email_id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D444AFBBA832C1C9 (email_id), UNIQUE INDEX UNIQ_D444AFBBBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE template_email ADD CONSTRAINT FK_D444AFBBA832C1C9 FOREIGN KEY (email_id) REFERENCES email (id)');
        $this->addSql('ALTER TABLE template_email ADD CONSTRAINT FK_D444AFBBBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_email (id)');
        $this->addSql('ALTER TABLE client CHANGE phase_client_id phase_client_id INT DEFAULT NULL, CHANGE age age INT DEFAULT NULL, CHANGE telephone telephone VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE template_email DROP FOREIGN KEY FK_D444AFBBBCF5E72D');
        $this->addSql('ALTER TABLE template_email DROP FOREIGN KEY FK_D444AFBBA832C1C9');
        $this->addSql('DROP TABLE categorie_email');
        $this->addSql('DROP TABLE email');
        $this->addSql('DROP TABLE template_email');
        $this->addSql('ALTER TABLE client CHANGE phase_client_id phase_client_id INT DEFAULT NULL, CHANGE age age INT DEFAULT NULL, CHANGE telephone telephone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
