<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181128165550 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, iso VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, is_publish TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture_category (id INT AUTO_INCREMENT NOT NULL, language_source_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, is_publish TINYINT(1) NOT NULL, INDEX IDX_6E8C8CCD535C678B (language_source_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture_category_language (picture_category_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_CA4FAEF38C0ED801 (picture_category_id), INDEX IDX_CA4FAEF382F1BAF4 (language_id), PRIMARY KEY(picture_category_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture_category_translation (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, is_translated TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture_category_translation_language (picture_category_translation_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_687251616A94D255 (picture_category_translation_id), INDEX IDX_6872516182F1BAF4 (language_id), PRIMARY KEY(picture_category_translation_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture_category_translation_picture_category (picture_category_translation_id INT NOT NULL, picture_category_id INT NOT NULL, INDEX IDX_C84268846A94D255 (picture_category_translation_id), INDEX IDX_C84268848C0ED801 (picture_category_id), PRIMARY KEY(picture_category_translation_id, picture_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE picture_category ADD CONSTRAINT FK_6E8C8CCD535C678B FOREIGN KEY (language_source_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE picture_category_language ADD CONSTRAINT FK_CA4FAEF38C0ED801 FOREIGN KEY (picture_category_id) REFERENCES picture_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture_category_language ADD CONSTRAINT FK_CA4FAEF382F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture_category_translation_language ADD CONSTRAINT FK_687251616A94D255 FOREIGN KEY (picture_category_translation_id) REFERENCES picture_category_translation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture_category_translation_language ADD CONSTRAINT FK_6872516182F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture_category_translation_picture_category ADD CONSTRAINT FK_C84268846A94D255 FOREIGN KEY (picture_category_translation_id) REFERENCES picture_category_translation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture_category_translation_picture_category ADD CONSTRAINT FK_C84268848C0ED801 FOREIGN KEY (picture_category_id) REFERENCES picture_category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE picture_category DROP FOREIGN KEY FK_6E8C8CCD535C678B');
        $this->addSql('ALTER TABLE picture_category_language DROP FOREIGN KEY FK_CA4FAEF382F1BAF4');
        $this->addSql('ALTER TABLE picture_category_translation_language DROP FOREIGN KEY FK_6872516182F1BAF4');
        $this->addSql('ALTER TABLE picture_category_language DROP FOREIGN KEY FK_CA4FAEF38C0ED801');
        $this->addSql('ALTER TABLE picture_category_translation_picture_category DROP FOREIGN KEY FK_C84268848C0ED801');
        $this->addSql('ALTER TABLE picture_category_translation_language DROP FOREIGN KEY FK_687251616A94D255');
        $this->addSql('ALTER TABLE picture_category_translation_picture_category DROP FOREIGN KEY FK_C84268846A94D255');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE picture_category');
        $this->addSql('DROP TABLE picture_category_language');
        $this->addSql('DROP TABLE picture_category_translation');
        $this->addSql('DROP TABLE picture_category_translation_language');
        $this->addSql('DROP TABLE picture_category_translation_picture_category');
    }
}
