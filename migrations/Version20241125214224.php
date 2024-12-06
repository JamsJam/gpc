<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241125214224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activites ADD image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE excursions ADD image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE promos ADD begin_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD end_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD titre VARCHAR(100) NOT NULL, ADD stripe_link1 VARCHAR(255) NOT NULL, ADD stripe_link2 VARCHAR(255) NOT NULL, ADD description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activites DROP image');
        $this->addSql('ALTER TABLE excursions DROP image');
        $this->addSql('ALTER TABLE promos DROP begin_at, DROP end_at, DROP titre, DROP stripe_link1, DROP stripe_link2, DROP description');
    }
}
