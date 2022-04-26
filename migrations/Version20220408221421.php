<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220408221421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lignecommande DROP FOREIGN KEY fkkkidplat');
        $this->addSql('ALTER TABLE lignecommande DROP FOREIGN KEY Idpanier');
        $this->addSql('ALTER TABLE lignecommande DROP FOREIGN KEY idclientt');
        $this->addSql('ALTER TABLE lignecommande CHANGE idplat idplat INT DEFAULT NULL, CHANGE Idpanier Idpanier INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lignecommande ADD CONSTRAINT FK_853B7939F3F753A7 FOREIGN KEY (idplat) REFERENCES platt (Idplat)');
        $this->addSql('ALTER TABLE lignecommande ADD CONSTRAINT FK_853B7939B907C208 FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier)');
        $this->addSql('ALTER TABLE lignecommande ADD CONSTRAINT FK_853B7939E173B1B8 FOREIGN KEY (id_client) REFERENCES clientinfo (id_client)');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY fkkkIdpanier');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY fkidcli');
        $this->addSql('DROP INDEX fkkkIdpanier ON paiement');
        $this->addSql('DROP INDEX fkidcli ON paiement');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lignecommande DROP FOREIGN KEY FK_853B7939F3F753A7');
        $this->addSql('ALTER TABLE lignecommande DROP FOREIGN KEY FK_853B7939B907C208');
        $this->addSql('ALTER TABLE lignecommande DROP FOREIGN KEY FK_853B7939E173B1B8');
        $this->addSql('ALTER TABLE lignecommande CHANGE idplat idplat INT NOT NULL, CHANGE Idpanier Idpanier INT NOT NULL');
        $this->addSql('ALTER TABLE lignecommande ADD CONSTRAINT fkkkidplat FOREIGN KEY (idplat) REFERENCES platt (Idplat) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lignecommande ADD CONSTRAINT Idpanier FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lignecommande ADD CONSTRAINT idclientt FOREIGN KEY (id_client) REFERENCES clientinfo (id_client) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT fkkkIdpanier FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT fkidcli FOREIGN KEY (id_client) REFERENCES clientinfo (id_client)');
        $this->addSql('CREATE INDEX fkkkIdpanier ON paiement (Idpanier)');
        $this->addSql('CREATE INDEX fkidcli ON paiement (id_client)');
    }
}
