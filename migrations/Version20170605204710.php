<?php

namespace MillmanPhotography\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170605204710 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE gallery_image (id INT AUTO_INCREMENT NOT NULL, gallery_id INT NOT NULL, image_id INT NOT NULL, date_created DATETIME NOT NULL, date_modified DATETIME NOT NULL, INDEX IDX_21A0D47C4E7AF8F (gallery_id), INDEX IDX_21A0D47C3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gallery_image ADD CONSTRAINT FK_21A0D47C4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id)');
        $this->addSql('ALTER TABLE gallery_image ADD CONSTRAINT FK_21A0D47C3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE enquiry CHANGE message message VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE gallery DROP image_id, CHANGE title title VARCHAR(64) NOT NULL, CHANGE description description VARCHAR(64) NOT NULL');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F4E7AF8F');
        $this->addSql('DROP INDEX IDX_C53D045F4E7AF8F ON image');
        $this->addSql('ALTER TABLE image DROP gallery_id, CHANGE filename filename VARCHAR(64) NOT NULL');
        $this->addSql('ALTER TABLE post CHANGE body body VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(64) NOT NULL, CHANGE password password VARCHAR(64) NOT NULL, CHANGE token token VARCHAR(512) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE gallery_image');
        $this->addSql('ALTER TABLE enquiry CHANGE message message VARCHAR(256) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE gallery ADD image_id INT NOT NULL, CHANGE title title VARCHAR(32) NOT NULL COLLATE utf8_unicode_ci, CHANGE description description VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE image ADD gallery_id INT NOT NULL, CHANGE filename filename VARCHAR(32) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F4E7AF8F ON image (gallery_id)');
        $this->addSql('ALTER TABLE post CHANGE body body VARCHAR(512) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(50) DEFAULT \'\' NOT NULL COLLATE utf8_unicode_ci, CHANGE password password TEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE token token TEXT NOT NULL COLLATE utf8_unicode_ci');
    }
}
