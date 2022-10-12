<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624052705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart ADD customerid_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B776F04A3B FOREIGN KEY (customerid_id) REFERENCES customer (id)');
        $this->addSql('CREATE INDEX IDX_BA388B776F04A3B ON cart (customerid_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B776F04A3B');
        $this->addSql('DROP INDEX IDX_BA388B776F04A3B ON cart');
        $this->addSql('ALTER TABLE cart DROP customerid_id');
    }
}
