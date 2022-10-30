<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220819085159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

        $this->addSql('CREATE TABLE auction_bids (
          id BINARY(16) NOT NULL,
          auction_id BINARY(16) DEFAULT NULL,
          user_id BINARY(16) DEFAULT NULL,
          amount NUMERIC(10, 2) NOT NULL,
          is_winner TINYINT(1) DEFAULT 0 NOT NULL,
          created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
          updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
          INDEX IDX_F49BC5BD57B8F0DE (auction_id),
          INDEX IDX_F49BC5BDA76ED395 (user_id),
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
  
        $this->addSql('CREATE TABLE auctions (
          id BINARY(16) NOT NULL,
          user_id BINARY(16) DEFAULT NULL,
          title VARCHAR(200) NOT NULL,
          description LONGTEXT NOT NULL,
          status VARCHAR(20) NOT NULL,
          initial_amount NUMERIC(10, 2) NOT NULL,
          created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
          updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
          INDEX IDX_72D6E900A76ED395 (user_id),
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE users (
          id BINARY(16) NOT NULL,
          username VARCHAR(60) NOT NULL,
          email VARCHAR(255) NOT NULL,
          password VARCHAR(255) NOT NULL,
          created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
          updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
          UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username),
          UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email),
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE
          auction_bids
        ADD
          CONSTRAINT FK_F49BC5BD57B8F0DE FOREIGN KEY (auction_id) REFERENCES auctions (id)');

        $this->addSql('ALTER TABLE
          auction_bids
        ADD
          CONSTRAINT FK_F49BC5BDA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        
        $this->addSql('ALTER TABLE
          auctions
        ADD
          CONSTRAINT FK_72D6E900A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auction_bids DROP FOREIGN KEY FK_F49BC5BD57B8F0DE');
        $this->addSql('ALTER TABLE auction_bids DROP FOREIGN KEY FK_F49BC5BDA76ED395');
        $this->addSql('ALTER TABLE auctions DROP FOREIGN KEY FK_72D6E900A76ED395');
        $this->addSql('DROP TABLE auction_bids');
        $this->addSql('DROP TABLE auctions');
        $this->addSql('DROP TABLE users');
    }
}
