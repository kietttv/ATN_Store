<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624053608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart ADD productid_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7AF89CCED FOREIGN KEY (productid_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_BA388B7AF89CCED ON cart (productid_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7AF89CCED');
        $this->addSql('DROP INDEX IDX_BA388B7AF89CCED ON cart');
        $this->addSql('ALTER TABLE cart DROP productid_id');
    }
}
