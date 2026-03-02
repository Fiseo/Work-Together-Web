<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260302141332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_unit_component DROP FOREIGN KEY `FK_CCE59625A203352D`');
        $this->addSql('ALTER TABLE booking_unit_component DROP FOREIGN KEY `FK_CCE59625E2ABAFFF`');
        $this->addSql('ALTER TABLE component DROP FOREIGN KEY `FK_49FEA157C54C8C93`');
        $this->addSql('ALTER TABLE unit_component DROP FOREIGN KEY `FK_578A6DD5E2ABAFFF`');
        $this->addSql('ALTER TABLE unit_component DROP FOREIGN KEY `FK_578A6DD5F8BD700D`');
        $this->addSql('DROP TABLE booking_unit_component');
        $this->addSql('DROP TABLE component');
        $this->addSql('DROP TABLE component_type');
        $this->addSql('DROP TABLE unit_component');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_unit_component (booking_unit_id INT NOT NULL, component_id INT NOT NULL, INDEX IDX_CCE59625A203352D (booking_unit_id), INDEX IDX_CCE59625E2ABAFFF (component_id), PRIMARY KEY (booking_unit_id, component_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE component (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, type_id INT NOT NULL, INDEX IDX_49FEA157C54C8C93 (type_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE component_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE unit_component (unit_id INT NOT NULL, component_id INT NOT NULL, INDEX IDX_578A6DD5E2ABAFFF (component_id), INDEX IDX_578A6DD5F8BD700D (unit_id), PRIMARY KEY (unit_id, component_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE booking_unit_component ADD CONSTRAINT `FK_CCE59625A203352D` FOREIGN KEY (booking_unit_id) REFERENCES booking_unit (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_unit_component ADD CONSTRAINT `FK_CCE59625E2ABAFFF` FOREIGN KEY (component_id) REFERENCES component (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE component ADD CONSTRAINT `FK_49FEA157C54C8C93` FOREIGN KEY (type_id) REFERENCES component_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE unit_component ADD CONSTRAINT `FK_578A6DD5E2ABAFFF` FOREIGN KEY (component_id) REFERENCES component (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE unit_component ADD CONSTRAINT `FK_578A6DD5F8BD700D` FOREIGN KEY (unit_id) REFERENCES unit (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
