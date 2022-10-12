<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220623135136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY product_ibfk_1');
        $this->addSql('ALTER TABLE orders_detail DROP FOREIGN KEY orderid_fk');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY abc');
        $this->addSql('ALTER TABLE orders_detail DROP FOREIGN KEY product_fk');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE orders_detail');
        $this->addSql('DROP TABLE product');
        $this->addSql('ALTER TABLE customer ADD id INT AUTO_INCREMENT NOT NULL, ADD customer_name VARCHAR(255) NOT NULL, DROP CustName, DROP telephone, DROP email, DROP CusDate, DROP CusMonth, DROP CusYear, DROP SSN, DROP ActiveCode, DROP state, CHANGE Username username VARCHAR(255) NOT NULL, CHANGE Password password VARCHAR(255) NOT NULL, CHANGE gender gender VARCHAR(255) NOT NULL, CHANGE Address address VARCHAR(255) NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart (record_id INT AUTO_INCREMENT NOT NULL, username VARCHAR(20) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, p_id VARCHAR(10) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, p_qty INT NOT NULL, date DATE NOT NULL, INDEX user_fk (username), INDEX abc (p_id), PRIMARY KEY(record_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE category (Cat_ID VARCHAR(10) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, Cat_Name VARCHAR(30) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, Cat_Des VARCHAR(1000) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(Cat_ID)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE orders (username VARCHAR(20) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, OrderID INT AUTO_INCREMENT NOT NULL, OrderDate DATETIME NOT NULL, DeliveryDate DATETIME DEFAULT NULL, Address VARCHAR(200) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, Payment INT DEFAULT 0 NOT NULL, status VARCHAR(10) CHARACTER SET utf8 DEFAULT \'packing\' COLLATE `utf8_general_ci`, INDEX username (username), PRIMARY KEY(OrderID)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE orders_detail (OrderDetail_ID INT AUTO_INCREMENT NOT NULL, Order_ID INT NOT NULL, Product_ID VARCHAR(10) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, Pro_Qty INT NOT NULL, Price DOUBLE PRECISION NOT NULL, Total DOUBLE PRECISION NOT NULL, INDEX product_fk (Product_ID), INDEX orderid_fk (Order_ID), PRIMARY KEY(OrderDetail_ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE product (Product_ID VARCHAR(10) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, Product_Name VARCHAR(30) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, Price BIGINT NOT NULL, oldPrice NUMERIC(12, 2) DEFAULT NULL, SmallDesc VARCHAR(1000) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, DetailDesc TEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, ProDate DATE NOT NULL, Pro_qty INT NOT NULL, Pro_image VARCHAR(200) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, Cat_ID VARCHAR(10) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, INDEX Cat_ID (Cat_ID), PRIMARY KEY(Product_ID)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT user_fk FOREIGN KEY (username) REFERENCES customer (Username) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT abc FOREIGN KEY (p_id) REFERENCES product (Product_ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT orders_ibfk_1 FOREIGN KEY (username) REFERENCES customer (Username) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders_detail ADD CONSTRAINT product_fk FOREIGN KEY (Product_ID) REFERENCES product (Product_ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders_detail ADD CONSTRAINT orderid_fk FOREIGN KEY (Order_ID) REFERENCES orders (OrderID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT product_ibfk_1 FOREIGN KEY (Cat_ID) REFERENCES category (Cat_ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE customer DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE customer ADD CustName VARCHAR(30) NOT NULL, ADD telephone VARCHAR(50) NOT NULL, ADD email VARCHAR(50) NOT NULL, ADD CusDate INT NOT NULL, ADD CusMonth INT NOT NULL, ADD CusYear INT NOT NULL, ADD SSN VARCHAR(10) DEFAULT NULL, ADD ActiveCode VARCHAR(100) NOT NULL, ADD state INT NOT NULL, DROP id, DROP customer_name, CHANGE username Username VARCHAR(20) NOT NULL, CHANGE password Password VARCHAR(40) NOT NULL, CHANGE gender gender VARCHAR(10) NOT NULL, CHANGE address Address VARCHAR(1000) NOT NULL');
        $this->addSql('ALTER TABLE customer ADD PRIMARY KEY (Username)');
    }
}
