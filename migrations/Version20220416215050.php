<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416215050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398B907C208');
        $this->addSql('ALTER TABLE `order` DROP date, DROP id_c');
        $this->addSql('DROP INDEX fk_f5299398b907c208 ON `order`');
        $this->addSql('CREATE INDEX fkkkIdpanierrrr ON `order` (Idpanier)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398B907C208 FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier)');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EB907C208');
        $this->addSql('DROP INDEX fk_b1dc7a1eb907c208 ON paiement');
        $this->addSql('CREATE INDEX fkkkIdpanier ON paiement (Idpanier)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EB907C208 FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier)');
        $this->addSql('ALTER TABLE panier ADD id_client INT DEFAULT NULL, ADD Rue VARCHAR(255) NOT NULL, ADD etat VARCHAR(255) NOT NULL, ADD Delegation VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2E173B1B8 FOREIGN KEY (id_client) REFERENCES clientinfo (id_client)');
        $this->addSql('CREATE INDEX id_client ON panier (id_client)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398B907C208');
        $this->addSql('ALTER TABLE `order` ADD date DATETIME NOT NULL, ADD id_c VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX fkkkidpanierrrr ON `order`');
        $this->addSql('CREATE INDEX FK_F5299398B907C208 ON `order` (Idpanier)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398B907C208 FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier)');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EB907C208');
        $this->addSql('DROP INDEX fkkkidpanier ON paiement');
        $this->addSql('CREATE INDEX FK_B1DC7A1EB907C208 ON paiement (Idpanier)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EB907C208 FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier)');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2E173B1B8');
        $this->addSql('DROP INDEX id_client ON panier');
        $this->addSql('ALTER TABLE panier DROP id_client, DROP Rue, DROP etat, DROP Delegation');
    }
}
