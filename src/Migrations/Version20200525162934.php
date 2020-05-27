<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200525162934 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comentar ADD restaurante_id INT NOT NULL, ADD resena_id INT NOT NULL, ADD usuario_id INT NOT NULL');
        $this->addSql('ALTER TABLE comentar ADD CONSTRAINT FK_E9ECAACE38B81E49 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id)');
        $this->addSql('ALTER TABLE comentar ADD CONSTRAINT FK_E9ECAACE19764015 FOREIGN KEY (resena_id) REFERENCES resena (id)');
        $this->addSql('ALTER TABLE comentar ADD CONSTRAINT FK_E9ECAACEDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_E9ECAACE38B81E49 ON comentar (restaurante_id)');
        $this->addSql('CREATE INDEX IDX_E9ECAACE19764015 ON comentar (resena_id)');
        $this->addSql('CREATE INDEX IDX_E9ECAACEDB38439E ON comentar (usuario_id)');
        $this->addSql('ALTER TABLE plato ADD seccion_id INT NOT NULL');
        $this->addSql('ALTER TABLE plato ADD CONSTRAINT FK_914B3E457A5A413A FOREIGN KEY (seccion_id) REFERENCES seccion (id)');
        $this->addSql('CREATE INDEX IDX_914B3E457A5A413A ON plato (seccion_id)');
        $this->addSql('ALTER TABLE promocion ADD plato_id INT NOT NULL, ADD oferta_id INT NOT NULL, ADD restaurante_id INT NOT NULL');
        $this->addSql('ALTER TABLE promocion ADD CONSTRAINT FK_CD312F7B0DB09EF FOREIGN KEY (plato_id) REFERENCES plato (id)');
        $this->addSql('ALTER TABLE promocion ADD CONSTRAINT FK_CD312F7FAFBF624 FOREIGN KEY (oferta_id) REFERENCES oferta (id)');
        $this->addSql('ALTER TABLE promocion ADD CONSTRAINT FK_CD312F738B81E49 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id)');
        $this->addSql('CREATE INDEX IDX_CD312F7B0DB09EF ON promocion (plato_id)');
        $this->addSql('CREATE INDEX IDX_CD312F7FAFBF624 ON promocion (oferta_id)');
        $this->addSql('CREATE INDEX IDX_CD312F738B81E49 ON promocion (restaurante_id)');
        $this->addSql('ALTER TABLE restaurante ADD datos_id INT NOT NULL, ADD informacion_id INT NOT NULL, ADD ubicacion_id INT NOT NULL');
        $this->addSql('ALTER TABLE restaurante ADD CONSTRAINT FK_5957C27577198A62 FOREIGN KEY (datos_id) REFERENCES datos (id)');
        $this->addSql('ALTER TABLE restaurante ADD CONSTRAINT FK_5957C2758C899341 FOREIGN KEY (informacion_id) REFERENCES informacion (id)');
        $this->addSql('ALTER TABLE restaurante ADD CONSTRAINT FK_5957C27557E759E8 FOREIGN KEY (ubicacion_id) REFERENCES ubicacion (id)');
        $this->addSql('CREATE INDEX IDX_5957C27577198A62 ON restaurante (datos_id)');
        $this->addSql('CREATE INDEX IDX_5957C2758C899341 ON restaurante (informacion_id)');
        $this->addSql('CREATE INDEX IDX_5957C27557E759E8 ON restaurante (ubicacion_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comentar DROP FOREIGN KEY FK_E9ECAACE38B81E49');
        $this->addSql('ALTER TABLE comentar DROP FOREIGN KEY FK_E9ECAACE19764015');
        $this->addSql('ALTER TABLE comentar DROP FOREIGN KEY FK_E9ECAACEDB38439E');
        $this->addSql('DROP INDEX IDX_E9ECAACE38B81E49 ON comentar');
        $this->addSql('DROP INDEX IDX_E9ECAACE19764015 ON comentar');
        $this->addSql('DROP INDEX IDX_E9ECAACEDB38439E ON comentar');
        $this->addSql('ALTER TABLE comentar DROP restaurante_id, DROP resena_id, DROP usuario_id');
        $this->addSql('ALTER TABLE plato DROP FOREIGN KEY FK_914B3E457A5A413A');
        $this->addSql('DROP INDEX IDX_914B3E457A5A413A ON plato');
        $this->addSql('ALTER TABLE plato DROP seccion_id');
        $this->addSql('ALTER TABLE promocion DROP FOREIGN KEY FK_CD312F7B0DB09EF');
        $this->addSql('ALTER TABLE promocion DROP FOREIGN KEY FK_CD312F7FAFBF624');
        $this->addSql('ALTER TABLE promocion DROP FOREIGN KEY FK_CD312F738B81E49');
        $this->addSql('DROP INDEX IDX_CD312F7B0DB09EF ON promocion');
        $this->addSql('DROP INDEX IDX_CD312F7FAFBF624 ON promocion');
        $this->addSql('DROP INDEX IDX_CD312F738B81E49 ON promocion');
        $this->addSql('ALTER TABLE promocion DROP plato_id, DROP oferta_id, DROP restaurante_id');
        $this->addSql('ALTER TABLE restaurante DROP FOREIGN KEY FK_5957C27577198A62');
        $this->addSql('ALTER TABLE restaurante DROP FOREIGN KEY FK_5957C2758C899341');
        $this->addSql('ALTER TABLE restaurante DROP FOREIGN KEY FK_5957C27557E759E8');
        $this->addSql('DROP INDEX IDX_5957C27577198A62 ON restaurante');
        $this->addSql('DROP INDEX IDX_5957C2758C899341 ON restaurante');
        $this->addSql('DROP INDEX IDX_5957C27557E759E8 ON restaurante');
        $this->addSql('ALTER TABLE restaurante DROP datos_id, DROP informacion_id, DROP ubicacion_id');
    }
}
