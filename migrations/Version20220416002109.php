<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416002109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lignecommande (idlc INT AUTO_INCREMENT NOT NULL, id_client INT DEFAULT NULL, Idpanier INT DEFAULT NULL, INDEX idclientt (id_client), INDEX FK_853B7939B907C208 (Idpanier), PRIMARY KEY(idlc)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lignecommande ADD CONSTRAINT FK_853B7939E173B1B8 FOREIGN KEY (id_client) REFERENCES clientinfo (id_client)');
        $this->addSql('ALTER TABLE lignecommande ADD CONSTRAINT FK_853B7939B907C208 FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY fkkkIdpanierrrr');
        $this->addSql('ALTER TABLE `order` CHANGE Idpanier Idpanier INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398B907C208 FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier)');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY fkkkIdpanier');
        $this->addSql('ALTER TABLE paiement CHANGE id_client id_client INT DEFAULT NULL, CHANGE Idpanier Idpanier INT DEFAULT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EB907C208 FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE lignecommande');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398B907C208');
        $this->addSql('ALTER TABLE `order` CHANGE Idpanier Idpanier INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT fkkkIdpanierrrr FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EB907C208');
        $this->addSql('ALTER TABLE paiement CHANGE id_client id_client INT NOT NULL, CHANGE Idpanier Idpanier INT NOT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT fkkkIdpanier FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier) ON DELETE CASCADE');
    }
}
