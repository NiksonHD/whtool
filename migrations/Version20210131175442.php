<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210131175442 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE daily_inputs ADD user_id INT DEFAULT NULL, ADD article_id INT DEFAULT NULL, CHANGE tile_description tile_description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE daily_inputs ADD CONSTRAINT FK_825F97E27294869C FOREIGN KEY (article_id) REFERENCES articles_info (id)');
        $this->addSql('ALTER TABLE daily_inputs ADD CONSTRAINT FK_825F97E2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_825F97E27294869C ON daily_inputs (article_id)');
        $this->addSql('CREATE INDEX IDX_825F97E2A76ED395 ON daily_inputs (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE daily_inputs DROP FOREIGN KEY FK_825F97E27294869C');
        $this->addSql('ALTER TABLE daily_inputs DROP FOREIGN KEY FK_825F97E2A76ED395');
        $this->addSql('DROP INDEX IDX_825F97E27294869C ON daily_inputs');
        $this->addSql('DROP INDEX IDX_825F97E2A76ED395 ON daily_inputs');
        $this->addSql('ALTER TABLE daily_inputs DROP user_id, DROP article_id, CHANGE tile_description tile_description VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
    }
}
