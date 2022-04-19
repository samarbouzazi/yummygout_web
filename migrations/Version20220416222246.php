<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416222246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY fk_idpanier');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1FB907C208 FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398B907C208');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398B907C208 FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier)');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EB907C208');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EB907C208 FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier)');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY fffkkkkidplat');
        $this->addSql('ALTER TABLE panier CHANGE order_id order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2F3F753A7 FOREIGN KEY (idplat) REFERENCES platt (Idplat)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1FB907C208');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT fk_idpanier FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398B907C208');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398B907C208 FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EB907C208');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EB907C208 FOREIGN KEY (Idpanier) REFERENCES panier (Idpanier) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2F3F753A7');
        $this->addSql('ALTER TABLE panier CHANGE order_id order_id INT NOT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT fffkkkkidplat FOREIGN KEY (idplat) REFERENCES platt (Idplat) ON DELETE CASCADE');
    }
}
