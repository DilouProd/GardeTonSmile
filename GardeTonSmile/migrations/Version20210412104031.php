<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210412104031 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add relation between publications ans users table';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publications ADD user_id INT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE update_at update_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE publications ADD CONSTRAINT FK_2A49E10CA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateurs (id)');
        $this->addSql('CREATE INDEX IDX_2A49E10CA76ED395 ON publications (user_id)');
        $this->addSql('ALTER TABLE utilisateurs CHANGE created_at created_at DATETIME NOT NULL, CHANGE update_at update_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Publications DROP FOREIGN KEY FK_2A49E10CA76ED395');
        $this->addSql('DROP INDEX IDX_2A49E10CA76ED395 ON Publications');
        $this->addSql('ALTER TABLE Publications DROP user_id, CHANGE created_at created_at DATETIME NOT NULL, CHANGE update_at update_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE utilisateurs CHANGE created_at created_at DATETIME NOT NULL, CHANGE update_at update_at DATETIME NOT NULL');
    }
}
