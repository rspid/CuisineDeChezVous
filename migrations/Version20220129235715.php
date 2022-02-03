<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220129235715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recette CHANGE temps_preparation temps_preparation TIME NOT NULL, CHANGE temps_cuisson temps_cuisson TIME NOT NULL, CHANGE temps_repos temps_repos TIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recette CHANGE temps_preparation temps_preparation DATETIME NOT NULL, CHANGE temps_cuisson temps_cuisson DATETIME NOT NULL, CHANGE temps_repos temps_repos DATETIME NOT NULL');
    }
}
