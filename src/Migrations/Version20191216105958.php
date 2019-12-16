<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191216105958 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE two_factor (id INT AUTO_INCREMENT NOT NULL, transaction_id INT NOT NULL, two_factor_code INT NOT NULL, returned_code INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_8468562DE774E17 (transaction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction_status (id INT AUTO_INCREMENT NOT NULL, name enum(\'draft\', \'approved\'), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE two_factor ADD CONSTRAINT FK_8468562DE774E17 FOREIGN KEY (transaction_id) REFERENCES transaction (id)');
        $this->addSql('INSERT INTO `transaction_status` (`name`) VALUES (\'draft\')');
        $this->addSql('INSERT INTO `transaction_status` (`name`) VALUES (\'approved\')');
        $this->addSql('ALTER TABLE transaction ADD status_id INT DEFAULT 1');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D16BF700BD FOREIGN KEY (status_id) REFERENCES transaction_status (id)');
        $this->addSql('CREATE INDEX IDX_723705D16BF700BD ON transaction (status_id)');
        $this->addSql("
        CREATE DEFINER = CURRENT_USER TRIGGER `transaction_AFTER_INSERT` AFTER INSERT ON `transaction` FOR EACH ROW
        BEGIN
	        INSERT INTO `two_factor` (transaction_id, two_factor_code, created_at, updated_at)
            VALUES (NEW.id, NEW.two_factor_code, NOW(), NOW());
        END;
        ");
        $this->addSql("
        CREATE DEFINER=`viktoras`@`localhost` TRIGGER `two_factor_BEFORE_UPDATE` BEFORE UPDATE ON `two_factor` FOR EACH ROW
        BEGIN
	        IF (NEW.two_factor_code = NEW.returned_code) THEN
		        UPDATE `transaction` SET status_id = (SELECT S.`id` FROM `transaction_status` AS S WHERE S.name = 'approved') WHERE `transaction`.`id` = NEW.transaction_id;
	        END IF;
        END;
        ");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D16BF700BD');
        $this->addSql('DROP TABLE two_factor');
        $this->addSql('DROP TABLE transaction_status');
        $this->addSql('DROP INDEX IDX_723705D16BF700BD ON transaction');
        $this->addSql('ALTER TABLE transaction DROP status_id');
    }
}
