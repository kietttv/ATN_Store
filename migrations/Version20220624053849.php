<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624053849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_detail ADD productid_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F46AF89CCED FOREIGN KEY (productid_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_ED896F46AF89CCED ON order_detail (productid_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F46AF89CCED');
        $this->addSql('DROP INDEX IDX_ED896F46AF89CCED ON order_detail');
        $this->addSql('ALTER TABLE order_detail DROP productid_id');
    }
}
