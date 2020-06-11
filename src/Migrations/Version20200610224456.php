<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200610224456 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Intervention DROP FOREIGN KEY FK_DMD');
        $this->addSql('ALTER TABLE Intervention DROP FOREIGN KEY FK_TECH');
        $this->addSql('ALTER TABLE Demande DROP FOREIGN KEY FK_M');
        $this->addSql('ALTER TABLE Technicien DROP FOREIGN KEY FK_M2');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE Demande');
        $this->addSql('DROP TABLE Intervention');
        $this->addSql('DROP TABLE Technicien');
        $this->addSql('DROP TABLE Utilisateur');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Demande (id_dmd INT AUTO_INCREMENT NOT NULL, matricule INT NOT NULL, titre VARCHAR(11) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, description VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, catgorie VARCHAR(11) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, priorite VARCHAR(11) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, etat VARCHAR(11) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, date_dmd DATE NOT NULL, INDEX FK_M (matricule), PRIMARY KEY(id_dmd)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Intervention (id_dmd INT NOT NULL, id_tech INT NOT NULL, date_intervention DATE NOT NULL, INDEX FK_TECH (id_tech), INDEX IDX_C929CF53B4B7E21F (id_dmd), PRIMARY KEY(id_dmd, id_tech)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Technicien (id_tech INT AUTO_INCREMENT NOT NULL, matricule INT NOT NULL, commentaire VARCHAR(300) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, INDEX FK_M2 (matricule), PRIMARY KEY(id_tech)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Utilisateur (matricule INT AUTO_INCREMENT NOT NULL, nom VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, prenom VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, login VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, mdp VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, PRIMARY KEY(matricule)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE Demande ADD CONSTRAINT FK_M FOREIGN KEY (matricule) REFERENCES Utilisateur (matricule) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Intervention ADD CONSTRAINT FK_DMD FOREIGN KEY (id_dmd) REFERENCES Demande (id_dmd) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Intervention ADD CONSTRAINT FK_TECH FOREIGN KEY (id_tech) REFERENCES Technicien (id_tech) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Technicien ADD CONSTRAINT FK_M2 FOREIGN KEY (matricule) REFERENCES Utilisateur (matricule) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP TABLE user');
    }
}
