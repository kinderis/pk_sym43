<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191113120059 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE provider_method (id INT AUTO_INCREMENT NOT NULL, method VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD provider_response VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE providers ADD method_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE providers ADD CONSTRAINT FK_E225D41719883967 FOREIGN KEY (method_id) REFERENCES provider_method (id)');
        $this->addSql('CREATE INDEX IDX_E225D41719883967 ON providers (method_id)');
        $this->addSql('INSERT INTO provider_method (method) VALUES (\'substrings\')');
        $this->addSql('INSERT INTO provider_method (method) VALUES (\'appends\')');
        $this->addSql('UPDATE providers t SET t.method_id = 1 WHERE t.id = 1');
        $this->addSql('UPDATE providers t SET t.method_id = 2 WHERE t.id = 2');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE providers DROP FOREIGN KEY FK_E225D41719883967');
        $this->addSql('DROP TABLE provider_method');
        $this->addSql('DROP INDEX IDX_E225D41719883967 ON providers');
        $this->addSql('ALTER TABLE providers DROP method_id');
        $this->addSql('ALTER TABLE transaction DROP provider_response');
    }
}
