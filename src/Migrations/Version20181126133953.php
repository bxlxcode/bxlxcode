<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181126133953 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, language_source_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_64C19C1535C678B (language_source_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_language_available (category_id INT NOT NULL, language_available_id INT NOT NULL, INDEX IDX_8EBD0C3512469DE2 (category_id), INDEX IDX_8EBD0C3513DF6F77 (language_available_id), PRIMARY KEY(category_id, language_available_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_translation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_translation_language_available (category_translation_id INT NOT NULL, language_available_id INT NOT NULL, INDEX IDX_E8A3BE897DBA6818 (category_translation_id), INDEX IDX_E8A3BE8913DF6F77 (language_available_id), PRIMARY KEY(category_translation_id, language_available_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_translation_category (category_translation_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_AD05DEA7DBA6818 (category_translation_id), INDEX IDX_AD05DEA12469DE2 (category_id), PRIMARY KEY(category_translation_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language_available (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, iso VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language_source (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, iso VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1535C678B FOREIGN KEY (language_source_id) REFERENCES language_source (id)');
        $this->addSql('ALTER TABLE category_language_available ADD CONSTRAINT FK_8EBD0C3512469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_language_available ADD CONSTRAINT FK_8EBD0C3513DF6F77 FOREIGN KEY (language_available_id) REFERENCES language_available (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_translation_language_available ADD CONSTRAINT FK_E8A3BE897DBA6818 FOREIGN KEY (category_translation_id) REFERENCES category_translation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_translation_language_available ADD CONSTRAINT FK_E8A3BE8913DF6F77 FOREIGN KEY (language_available_id) REFERENCES language_available (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_translation_category ADD CONSTRAINT FK_AD05DEA7DBA6818 FOREIGN KEY (category_translation_id) REFERENCES category_translation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_translation_category ADD CONSTRAINT FK_AD05DEA12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category_language_available DROP FOREIGN KEY FK_8EBD0C3512469DE2');
        $this->addSql('ALTER TABLE category_translation_category DROP FOREIGN KEY FK_AD05DEA12469DE2');
        $this->addSql('ALTER TABLE category_translation_language_available DROP FOREIGN KEY FK_E8A3BE897DBA6818');
        $this->addSql('ALTER TABLE category_translation_category DROP FOREIGN KEY FK_AD05DEA7DBA6818');
        $this->addSql('ALTER TABLE category_language_available DROP FOREIGN KEY FK_8EBD0C3513DF6F77');
        $this->addSql('ALTER TABLE category_translation_language_available DROP FOREIGN KEY FK_E8A3BE8913DF6F77');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1535C678B');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_language_available');
        $this->addSql('DROP TABLE category_translation');
        $this->addSql('DROP TABLE category_translation_language_available');
        $this->addSql('DROP TABLE category_translation_category');
        $this->addSql('DROP TABLE language_available');
        $this->addSql('DROP TABLE language_source');
    }
}
