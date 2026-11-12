<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261112083911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe ADD projet_id INT DEFAULT NULL, ADD responsable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA15C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA1553C59D72 FOREIGN KEY (responsable_id) REFERENCES inscription (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2449BA1553C59D72 ON equipe (responsable_id)');
        $this->addSql('CREATE INDEX IDX_2449BA15C18272 ON equipe (projet_id)');
        $this->addSql('ALTER TABLE hackathon CHANGE organisateur_id organisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE hackathon ADD CONSTRAINT FK_8B3AF64FD936B2FA FOREIGN KEY (organisateur_id) REFERENCES organisateur (id)');
        $this->addSql('CREATE INDEX IDX_8B3AF64FD936B2FA ON hackathon (organisateur_id)');
        $this->addSql('ALTER TABLE inscription ADD hackathon_id INT NOT NULL, ADD participant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6996D90CF FOREIGN KEY (hackathon_id) REFERENCES hackathon (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D69D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D6996D90CF ON inscription (hackathon_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D69D1C3019 ON inscription (participant_id)');
        $this->addSql('ALTER TABLE projet CHANGE hackathon_id hackathon_id INT NOT NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9996D90CF FOREIGN KEY (hackathon_id) REFERENCES hackathon (id)');
        $this->addSql('CREATE INDEX IDX_50159CA9996D90CF ON projet (hackathon_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA15C18272');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA1553C59D72');
        $this->addSql('DROP INDEX UNIQ_2449BA1553C59D72 ON equipe');
        $this->addSql('DROP INDEX IDX_2449BA15C18272 ON equipe');
        $this->addSql('ALTER TABLE equipe DROP projet_id, DROP responsable_id');
        $this->addSql('ALTER TABLE hackathon DROP FOREIGN KEY FK_8B3AF64FD936B2FA');
        $this->addSql('DROP INDEX IDX_8B3AF64FD936B2FA ON hackathon');
        $this->addSql('ALTER TABLE hackathon CHANGE organisateur_id organisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6996D90CF');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D69D1C3019');
        $this->addSql('DROP INDEX IDX_5E90F6D6996D90CF ON inscription');
        $this->addSql('DROP INDEX IDX_5E90F6D69D1C3019 ON inscription');
        $this->addSql('ALTER TABLE inscription DROP hackathon_id, DROP participant_id');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9996D90CF');
        $this->addSql('DROP INDEX IDX_50159CA9996D90CF ON projet');
        $this->addSql('ALTER TABLE projet CHANGE hackathon_id hackathon_id INT DEFAULT NULL');
    }
}
