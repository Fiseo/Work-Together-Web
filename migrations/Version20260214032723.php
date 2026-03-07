<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260214032723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bay (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, is_monthly TINYINT NOT NULL, start DATE NOT NULL, end DATE NOT NULL, offer_id INT NOT NULL, client_id INT NOT NULL, INDEX IDX_E00CEDDE53C674EE (offer_id), INDEX IDX_E00CEDDE19EB6921 (client_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE booking_unit (id INT AUTO_INCREMENT NOT NULL, start DATE NOT NULL, end DATE NOT NULL, booking_id INT NOT NULL, unit_id INT NOT NULL, INDEX IDX_C42A2E1D3301C60 (booking_id), INDEX IDX_C42A2E1DF8BD700D (unit_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE booking_unit_component (booking_unit_id INT NOT NULL, component_id INT NOT NULL, INDEX IDX_CCE59625A203352D (booking_unit_id), INDEX IDX_CCE59625E2ABAFFF (component_id), PRIMARY KEY (booking_unit_id, component_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE civility (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE component (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, type_id INT NOT NULL, INDEX IDX_49FEA157C54C8C93 (type_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE component_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, discount INT NOT NULL, unit_provided INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE service_call (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, technician_id INT NOT NULL, unit_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_2CD9BD2E6C5D496 (technician_id), INDEX IDX_2CD9BD2F8BD700D (unit_id), INDEX IDX_2CD9BD2C54C8C93 (type_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE service_call_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, have_problem TINYINT NOT NULL, bay_id INT NOT NULL, INDEX IDX_DCBB0C53DF9BA23B (bay_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE unit_component (unit_id INT NOT NULL, component_id INT NOT NULL, INDEX IDX_578A6DD5F8BD700D (unit_id), INDEX IDX_578A6DD5E2ABAFFF (component_id), PRIMARY KEY (unit_id, component_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, last_connection DATETIME DEFAULT NULL, type VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, civility_id INT DEFAULT NULL, review LONGTEXT DEFAULT NULL, rating INT DEFAULT NULL, birth_date DATE DEFAULT NULL, company_register VARCHAR(14) DEFAULT NULL, creation DATE DEFAULT NULL, INDEX IDX_8D93D64923D6A298 (civility_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE19EB6921 FOREIGN KEY (client_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE booking_unit ADD CONSTRAINT FK_C42A2E1D3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('ALTER TABLE booking_unit ADD CONSTRAINT FK_C42A2E1DF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE booking_unit_component ADD CONSTRAINT FK_CCE59625A203352D FOREIGN KEY (booking_unit_id) REFERENCES booking_unit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_unit_component ADD CONSTRAINT FK_CCE59625E2ABAFFF FOREIGN KEY (component_id) REFERENCES component (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE component ADD CONSTRAINT FK_49FEA157C54C8C93 FOREIGN KEY (type_id) REFERENCES component_type (id)');
        $this->addSql('ALTER TABLE service_call ADD CONSTRAINT FK_2CD9BD2E6C5D496 FOREIGN KEY (technician_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE service_call ADD CONSTRAINT FK_2CD9BD2F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE service_call ADD CONSTRAINT FK_2CD9BD2C54C8C93 FOREIGN KEY (type_id) REFERENCES service_call_type (id)');
        $this->addSql('ALTER TABLE unit ADD CONSTRAINT FK_DCBB0C53DF9BA23B FOREIGN KEY (bay_id) REFERENCES bay (id)');
        $this->addSql('ALTER TABLE unit_component ADD CONSTRAINT FK_578A6DD5F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE unit_component ADD CONSTRAINT FK_578A6DD5E2ABAFFF FOREIGN KEY (component_id) REFERENCES component (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64923D6A298 FOREIGN KEY (civility_id) REFERENCES civility (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE53C674EE');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE19EB6921');
        $this->addSql('ALTER TABLE booking_unit DROP FOREIGN KEY FK_C42A2E1D3301C60');
        $this->addSql('ALTER TABLE booking_unit DROP FOREIGN KEY FK_C42A2E1DF8BD700D');
        $this->addSql('ALTER TABLE booking_unit_component DROP FOREIGN KEY FK_CCE59625A203352D');
        $this->addSql('ALTER TABLE booking_unit_component DROP FOREIGN KEY FK_CCE59625E2ABAFFF');
        $this->addSql('ALTER TABLE component DROP FOREIGN KEY FK_49FEA157C54C8C93');
        $this->addSql('ALTER TABLE service_call DROP FOREIGN KEY FK_2CD9BD2E6C5D496');
        $this->addSql('ALTER TABLE service_call DROP FOREIGN KEY FK_2CD9BD2F8BD700D');
        $this->addSql('ALTER TABLE service_call DROP FOREIGN KEY FK_2CD9BD2C54C8C93');
        $this->addSql('ALTER TABLE unit DROP FOREIGN KEY FK_DCBB0C53DF9BA23B');
        $this->addSql('ALTER TABLE unit_component DROP FOREIGN KEY FK_578A6DD5F8BD700D');
        $this->addSql('ALTER TABLE unit_component DROP FOREIGN KEY FK_578A6DD5E2ABAFFF');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64923D6A298');
        $this->addSql('DROP TABLE bay');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE booking_unit');
        $this->addSql('DROP TABLE booking_unit_component');
        $this->addSql('DROP TABLE civility');
        $this->addSql('DROP TABLE component');
        $this->addSql('DROP TABLE component_type');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE service_call');
        $this->addSql('DROP TABLE service_call_type');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE unit_component');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
