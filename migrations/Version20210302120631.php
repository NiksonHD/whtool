<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210302120631 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE daily_inputs CHANGE device_zone device_zone VARCHAR(32) DEFAULT NULL');
        $this->addSql('ALTER TABLE lists CHANGE device_zone device_zone VARCHAR(32) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE daily_inputs CHANGE device_zone device_zone VARCHAR(32) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE lists CHANGE device_zone device_zone VARCHAR(32) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
    }
}
