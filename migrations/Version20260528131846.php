<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260528131846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE receipt (id INT AUTO_INCREMENT NOT NULL, invoice_number VARCHAR(10) NOT NULL, creation DATE NOT NULL, name VARCHAR(255) NOT NULL, company_register VARCHAR(14) DEFAULT NULL, total_ht INT NOT NULL, total_tva INT NOT NULL, total_ttc INT NOT NULL, start_period DATE NOT NULL, end_period DATE NOT NULL, booking_id INT DEFAULT NULL, price_id INT NOT NULL, INDEX IDX_5399B6453301C60 (booking_id), INDEX IDX_5399B645D614C7E7 (price_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE receipt ADD CONSTRAINT FK_5399B6453301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('ALTER TABLE receipt ADD CONSTRAINT FK_5399B645D614C7E7 FOREIGN KEY (price_id) REFERENCES price (id)');
        $this->addSql('ALTER TABLE price ADD preceding_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT `FK_CAC822D97A0B5CF3` FOREIGN KEY (preceding_id) REFERENCES price (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CAC822D97A0B5CF3 ON price (preceding_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE receipt DROP FOREIGN KEY FK_5399B6453301C60');
        $this->addSql('ALTER TABLE receipt DROP FOREIGN KEY FK_5399B645D614C7E7');
        $this->addSql('DROP TABLE receipt');
        $this->addSql('ALTER TABLE price DROP FOREIGN KEY `FK_CAC822D97A0B5CF3`');
        $this->addSql('DROP INDEX UNIQ_CAC822D97A0B5CF3 ON price');
        $this->addSql('ALTER TABLE price DROP preceding_id');
    }
}
