<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624053729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_detail ADD orderid_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F466F90D45B FOREIGN KEY (orderid_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_ED896F466F90D45B ON order_detail (orderid_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F466F90D45B');
        $this->addSql('DROP INDEX IDX_ED896F466F90D45B ON order_detail');
        $this->addSql('ALTER TABLE order_detail DROP orderid_id');
    }
}
