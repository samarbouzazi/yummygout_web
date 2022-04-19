<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220402235156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis CHANGE id_client id_client INT DEFAULT NULL');
        $this->addSql('ALTER TABLE clientinfo CHANGE id id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lignecommande CHANGE id_client id_client INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison CHANGE Idp Idp INT DEFAULT NULL, CHANGE Idpanier Idpanier INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier CHANGE idplat idplat INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personnell CHANGE id id INT DEFAULT NULL, CHANGE prime prime DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE platt CHANGE idcatt idcatt INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamantionlivraison CHANGE id_livraison id_livraison INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamationn CHANGE Idp Idp INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis CHANGE id_client id_client INT NOT NULL');
        $this->addSql('ALTER TABLE clientinfo CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE lignecommande CHANGE id_client id_client INT NOT NULL');
        $this->addSql('ALTER TABLE livraison CHANGE Idp Idp INT NOT NULL, CHANGE Idpanier Idpanier INT NOT NULL');
        $this->addSql('ALTER TABLE panier CHANGE idplat idplat INT NOT NULL');
        $this->addSql('ALTER TABLE personnell CHANGE id id INT NOT NULL, CHANGE prime prime DOUBLE PRECISION DEFAULT \'0\'');
        $this->addSql('ALTER TABLE platt CHANGE idcatt idcatt INT NOT NULL');
        $this->addSql('ALTER TABLE reclamantionlivraison CHANGE id_livraison id_livraison INT NOT NULL');
        $this->addSql('ALTER TABLE reclamationn CHANGE Idp Idp INT NOT NULL');
    }
}
