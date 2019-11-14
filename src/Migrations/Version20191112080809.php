<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191112080809 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction ADD user_id INT NOT NULL, ADD currency_id INT NOT NULL, ADD details VARCHAR(255) DEFAULT NULL, ADD receiver_account VARCHAR(255) NOT NULL, ADD receiver_name VARCHAR(255) NOT NULL, ADD amount NUMERIC(10, 0) NOT NULL, ADD two_factor_code INT DEFAULT NULL, ADD accepted INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD transaction_end INT DEFAULT NULL, ADD transaction_fee INT NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A76ED395 FOREIGN KEY (user_id) REFERENCES web_user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D138248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
        $this->addSql('CREATE INDEX IDX_723705D1A76ED395 ON transaction (user_id)');
        $this->addSql('CREATE INDEX IDX_723705D138248176 ON transaction (currency_id)');
        $this->addSql('ALTER TABLE web_user DROP FOREIGN KEY FK_4991DBBC16FE72E1');
        $this->addSql('DROP INDEX IDX_4991DBBC16FE72E1 ON web_user');
        $this->addSql('ALTER TABLE web_user ADD receiver_account VARCHAR(100) NOT NULL, DROP updated_by');
        $this->addSql('INSERT INTO web_user (name, surname, concated_name, is_active, created_at, updated_at, email, password,  receiver_account) VALUES (\'Admin\',\'Root\',\'Admin Root\',\'1\',\'2019-11-12 13:43:14\',\'2019-11-12 13:43:14\',\'root@example.com\',\'$argon2i$v=19$m=65536,t=4,p=1$R3lidURMTE1NNEp4a3BpUA$4Gww5OjCYZq5ws0VUSYRacb6qat5J9axUX0xlLNqp+c\',\'12345\')');
        $this->addSql('INSERT INTO currency (name) VALUES (\'EUR\')');
        $this->addSql('INSERT INTO currency (name) VALUES (\'USD\')');
        $this->addSql('INSERT INTO providers (name) VALUES (\'Megacash\')');
        $this->addSql('INSERT INTO providers (name) VALUES (\'Supermoney\')');
        $this->addSql('INSERT INTO currency_in_provider (currency_id, provider_id) VALUES (1, 1)');
        $this->addSql('INSERT INTO currency_in_provider (currency_id, provider_id) VALUES (2, 2)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1A76ED395');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D138248176');
        $this->addSql('DROP INDEX IDX_723705D1A76ED395 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D138248176 ON transaction');
        $this->addSql('ALTER TABLE transaction DROP user_id, DROP currency_id, DROP details, DROP receiver_account, DROP receiver_name, DROP amount, DROP two_factor_code, DROP accepted, DROP created_at, DROP updated_at, DROP transaction_end, DROP transaction_fee');
        $this->addSql('ALTER TABLE web_user ADD updated_by INT DEFAULT NULL, DROP receiver_account');
        $this->addSql('ALTER TABLE web_user ADD CONSTRAINT FK_4991DBBC16FE72E1 FOREIGN KEY (updated_by) REFERENCES web_user (id)');
        $this->addSql('CREATE INDEX IDX_4991DBBC16FE72E1 ON web_user (updated_by)');
    }
}
