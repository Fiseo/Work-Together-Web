<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260303104621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY `FK_E00CEDDE19EB6921`');
        $this->addSql('DROP INDEX IDX_E00CEDDE19EB6921 ON booking');
        $this->addSql('ALTER TABLE booking ADD individual_id INT DEFAULT NULL, ADD company_id INT DEFAULT NULL, DROP client_id');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEAE271C0D FOREIGN KEY (individual_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE979B1AD6 FOREIGN KEY (company_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEAE271C0D ON booking (individual_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE979B1AD6 ON booking (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEAE271C0D');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE979B1AD6');
        $this->addSql('DROP INDEX IDX_E00CEDDEAE271C0D ON booking');
        $this->addSql('DROP INDEX IDX_E00CEDDE979B1AD6 ON booking');
        $this->addSql('ALTER TABLE booking ADD client_id INT NOT NULL, DROP individual_id, DROP company_id');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT `FK_E00CEDDE19EB6921` FOREIGN KEY (client_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E00CEDDE19EB6921 ON booking (client_id)');
    }
}
