<?php declare(strict_types = 1);

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180417025008 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE empresa (id INT AUTO_INCREMENT NOT NULL, empresa INT DEFAULT NULL, tipo INT DEFAULT 1 NOT NULL, cover VARCHAR(255) DEFAULT \'/dist/uploads/images/no_image.jpg\' NOT NULL, social VARCHAR(220) DEFAULT \'NOVA EMPRESA\', fantasia VARCHAR(60) DEFAULT \'NOVA EMPRESA\', cnpj VARCHAR(14) DEFAULT NULL, ie VARCHAR(14) DEFAULT \'ISENTO\', phone VARCHAR(50) DEFAULT \'(48)35351603\', email VARCHAR(220) DEFAULT NULL, google VARCHAR(50) NOT NULL, facebook VARCHAR(50) DEFAULT \'claudio.coelho.175\' NOT NULL, twitter VARCHAR(50) DEFAULT \'callcocam\' NOT NULL, street VARCHAR(60) DEFAULT \'Rua Oscar de Oliveira Lopes\', complements VARCHAR(60) DEFAULT \'Complement\', number VARCHAR(10) DEFAULT \'355\', district VARCHAR(30) DEFAULT \'Bela Vista\', zip VARCHAR(8) DEFAULT \'88950000\', city VARCHAR(30) DEFAULT \'Jacinto Machado\', state VARCHAR(2) DEFAULT \'SC\', country VARCHAR(20) DEFAULT \'BRASIL\', longetude VARCHAR(20) DEFAULT \'-49.7612579\' NOT NULL, latitude VARCHAR(20) DEFAULT \'-29.0003557\' NOT NULL, description TEXT NOT NULL, status INT DEFAULT 1 NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, INDEX IDX_B8D75A50B8D75A50 (empresa), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE empresa ADD CONSTRAINT FK_B8D75A50B8D75A50 FOREIGN KEY (empresa) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE user ADD empresa INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B8D75A50 FOREIGN KEY (empresa) REFERENCES empresa (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649B8D75A50 ON user (empresa)');
        $this->addSql('ALTER TABLE cliente ADD empresa INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cliente ADD CONSTRAINT FK_F41C9B25B8D75A50 FOREIGN KEY (empresa) REFERENCES empresa (id)');
        $this->addSql('CREATE INDEX IDX_F41C9B25B8D75A50 ON cliente (empresa)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE empresa DROP FOREIGN KEY FK_B8D75A50B8D75A50');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B8D75A50');
        $this->addSql('ALTER TABLE cliente DROP FOREIGN KEY FK_F41C9B25B8D75A50');
        $this->addSql('DROP TABLE empresa');
        $this->addSql('DROP INDEX IDX_F41C9B25B8D75A50 ON cliente');
        $this->addSql('ALTER TABLE cliente DROP empresa');
        $this->addSql('DROP INDEX IDX_8D93D649B8D75A50 ON user');
        $this->addSql('ALTER TABLE user DROP empresa');
    }
}
