<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191112071327 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE currency (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE providers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_set (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, name LONGTEXT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_5276A1AEB03A8386 (created_by_id), INDEX IDX_5276A1AE896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_set_role (role_set_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_E87D8ED2BBDDECA9 (role_set_id), INDEX IDX_E87D8ED2D60322AC (role_id), PRIMARY KEY(role_set_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_set_web_user (role_set_id INT NOT NULL, web_user_id INT NOT NULL, INDEX IDX_E32E6C5DBBDDECA9 (role_set_id), INDEX IDX_E32E6C5D4FC17D0B (web_user_id), PRIMARY KEY(role_set_id, web_user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE currency_in_provider (id INT AUTO_INCREMENT NOT NULL, currency_id INT NOT NULL, provider_id INT NOT NULL, INDEX IDX_64D5016138248176 (currency_id), INDEX IDX_64D50161A53A8AA (provider_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(100) NOT NULL, name VARCHAR(100) DEFAULT NULL, hrd_vlu VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE web_user (id INT AUTO_INCREMENT NOT NULL, updated_by INT DEFAULT NULL, name VARCHAR(45) DEFAULT NULL, surname VARCHAR(45) DEFAULT NULL, concated_name VARCHAR(100) DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, phone VARCHAR(15) DEFAULT NULL, role_id INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_4991DBBC16FE72E1 (updated_by), UNIQUE INDEX uniq_1483a5e9e7927c74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE web_user_role (web_user_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_F34407774FC17D0B (web_user_id), INDEX IDX_F3440777D60322AC (role_id), PRIMARY KEY(web_user_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE role_set ADD CONSTRAINT FK_5276A1AEB03A8386 FOREIGN KEY (created_by_id) REFERENCES web_user (id)');
        $this->addSql('ALTER TABLE role_set ADD CONSTRAINT FK_5276A1AE896DBBDE FOREIGN KEY (updated_by_id) REFERENCES web_user (id)');
        $this->addSql('ALTER TABLE role_set_role ADD CONSTRAINT FK_E87D8ED2BBDDECA9 FOREIGN KEY (role_set_id) REFERENCES role_set (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_set_role ADD CONSTRAINT FK_E87D8ED2D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_set_web_user ADD CONSTRAINT FK_E32E6C5DBBDDECA9 FOREIGN KEY (role_set_id) REFERENCES role_set (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_set_web_user ADD CONSTRAINT FK_E32E6C5D4FC17D0B FOREIGN KEY (web_user_id) REFERENCES web_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE currency_in_provider ADD CONSTRAINT FK_64D5016138248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
        $this->addSql('ALTER TABLE currency_in_provider ADD CONSTRAINT FK_64D50161A53A8AA FOREIGN KEY (provider_id) REFERENCES providers (id)');
        $this->addSql('ALTER TABLE web_user ADD CONSTRAINT FK_4991DBBC16FE72E1 FOREIGN KEY (updated_by) REFERENCES web_user (id)');
        $this->addSql('ALTER TABLE web_user_role ADD CONSTRAINT FK_F34407774FC17D0B FOREIGN KEY (web_user_id) REFERENCES web_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE web_user_role ADD CONSTRAINT FK_F3440777D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE currency_in_provider DROP FOREIGN KEY FK_64D5016138248176');
        $this->addSql('ALTER TABLE currency_in_provider DROP FOREIGN KEY FK_64D50161A53A8AA');
        $this->addSql('ALTER TABLE role_set_role DROP FOREIGN KEY FK_E87D8ED2BBDDECA9');
        $this->addSql('ALTER TABLE role_set_web_user DROP FOREIGN KEY FK_E32E6C5DBBDDECA9');
        $this->addSql('ALTER TABLE role_set_role DROP FOREIGN KEY FK_E87D8ED2D60322AC');
        $this->addSql('ALTER TABLE web_user_role DROP FOREIGN KEY FK_F3440777D60322AC');
        $this->addSql('ALTER TABLE role_set DROP FOREIGN KEY FK_5276A1AEB03A8386');
        $this->addSql('ALTER TABLE role_set DROP FOREIGN KEY FK_5276A1AE896DBBDE');
        $this->addSql('ALTER TABLE role_set_web_user DROP FOREIGN KEY FK_E32E6C5D4FC17D0B');
        $this->addSql('ALTER TABLE web_user DROP FOREIGN KEY FK_4991DBBC16FE72E1');
        $this->addSql('ALTER TABLE web_user_role DROP FOREIGN KEY FK_F34407774FC17D0B');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE providers');
        $this->addSql('DROP TABLE role_set');
        $this->addSql('DROP TABLE role_set_role');
        $this->addSql('DROP TABLE role_set_web_user');
        $this->addSql('DROP TABLE currency_in_provider');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE web_user');
        $this->addSql('DROP TABLE web_user_role');
    }
}
