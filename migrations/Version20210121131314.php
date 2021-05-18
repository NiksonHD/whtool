<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210121131314 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles_info (id INT AUTO_INCREMENT NOT NULL, article_num INT NOT NULL, article_name VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, ean VARCHAR(20) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, quantity VARCHAR(11) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, update_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE count_lists (id INT AUTO_INCREMENT NOT NULL, current_count VARCHAR(250) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE csv_files_stamps (id INT AUTO_INCREMENT NOT NULL, file_stamp VARCHAR(250) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, file_name VARCHAR(250) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE daily_inputs (id INT AUTO_INCREMENT NOT NULL, input VARCHAR(256) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, tile_description VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, input_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE history_map (id INT AUTO_INCREMENT NOT NULL, cell VARCHAR(150) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, tile VARCHAR(10000) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, update_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lists (id INT AUTO_INCREMENT NOT NULL, comment VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, name_list DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, sap_list VARCHAR(21000) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, send_email TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tile_map (id INT AUTO_INCREMENT NOT NULL, tile_cell VARCHAR(250) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, sap_num VARCHAR(21000) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, comment VARCHAR(250) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, update_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE web (id INT AUTO_INCREMENT NOT NULL, order_num VARCHAR(250) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, delivery_num VARCHAR(250) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, update_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE `user`');
    }
}
