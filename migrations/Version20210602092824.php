<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210602092824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE cagnotte ADD category_id INT NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE cagnotte ADD CONSTRAINT FK_6342C75212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE cagnotte ADD CONSTRAINT FK_6342C752A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_6342C75212469DE2 ON cagnotte (category_id)');
        $this->addSql('CREATE INDEX IDX_6342C752A76ED395 ON cagnotte (user_id)');
        $this->addSql('ALTER TABLE don_phy ADD category_id INT NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE don_phy ADD CONSTRAINT FK_7E579CB812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE don_phy ADD CONSTRAINT FK_7E579CB8A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_7E579CB812469DE2 ON don_phy (category_id)');
        $this->addSql('CREATE INDEX IDX_7E579CB8A76ED395 ON don_phy (user_id)');
        $this->addSql('ALTER TABLE event ADD category_id INT NOT NULL, ADD user_id INT NOT NULL, ADD urlphoto VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA712469DE2 ON event (category_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7A76ED395 ON event (user_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cagnotte DROP FOREIGN KEY FK_6342C75212469DE2');
        $this->addSql('ALTER TABLE don_phy DROP FOREIGN KEY FK_7E579CB812469DE2');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA712469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('ALTER TABLE admin CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE cagnotte DROP FOREIGN KEY FK_6342C752A76ED395');
        $this->addSql('DROP INDEX IDX_6342C75212469DE2 ON cagnotte');
        $this->addSql('DROP INDEX IDX_6342C752A76ED395 ON cagnotte');
        $this->addSql('ALTER TABLE cagnotte DROP category_id, DROP user_id');
        $this->addSql('ALTER TABLE don_phy DROP FOREIGN KEY FK_7E579CB8A76ED395');
        $this->addSql('DROP INDEX IDX_7E579CB812469DE2 ON don_phy');
        $this->addSql('DROP INDEX IDX_7E579CB8A76ED395 ON don_phy');
        $this->addSql('ALTER TABLE don_phy DROP category_id, DROP user_id');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7A76ED395');
        $this->addSql('DROP INDEX IDX_3BAE0AA712469DE2 ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA7A76ED395 ON event');
        $this->addSql('ALTER TABLE event DROP category_id, DROP user_id, DROP urlphoto');
        $this->addSql('ALTER TABLE `user` CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
