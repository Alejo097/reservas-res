<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200525164145 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE guardar_imagen ADD imagen_id INT NOT NULL, ADD restaurante_id INT NOT NULL');
        $this->addSql('ALTER TABLE guardar_imagen ADD CONSTRAINT FK_10EE15A2763C8AA7 FOREIGN KEY (imagen_id) REFERENCES imagen (id)');
        $this->addSql('ALTER TABLE guardar_imagen ADD CONSTRAINT FK_10EE15A238B81E49 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id)');
        $this->addSql('CREATE INDEX IDX_10EE15A2763C8AA7 ON guardar_imagen (imagen_id)');
        $this->addSql('CREATE INDEX IDX_10EE15A238B81E49 ON guardar_imagen (restaurante_id)');
        $this->addSql('ALTER TABLE restaurante ADD usuario_id INT NOT NULL');
        $this->addSql('ALTER TABLE restaurante ADD CONSTRAINT FK_5957C275DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_5957C275DB38439E ON restaurante (usuario_id)');
        $this->addSql('ALTER TABLE subir_imagen ADD usuario_id INT NOT NULL, ADD imagen_id INT NOT NULL');
        $this->addSql('ALTER TABLE subir_imagen ADD CONSTRAINT FK_8B95F4CBDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE subir_imagen ADD CONSTRAINT FK_8B95F4CB763C8AA7 FOREIGN KEY (imagen_id) REFERENCES imagen (id)');
        $this->addSql('CREATE INDEX IDX_8B95F4CBDB38439E ON subir_imagen (usuario_id)');
        $this->addSql('CREATE INDEX IDX_8B95F4CB763C8AA7 ON subir_imagen (imagen_id)');
        $this->addSql('ALTER TABLE tiene_seccion ADD restaurante_id INT NOT NULL, ADD seccion_id INT NOT NULL');
        $this->addSql('ALTER TABLE tiene_seccion ADD CONSTRAINT FK_C94CE78638B81E49 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id)');
        $this->addSql('ALTER TABLE tiene_seccion ADD CONSTRAINT FK_C94CE7867A5A413A FOREIGN KEY (seccion_id) REFERENCES seccion (id)');
        $this->addSql('CREATE INDEX IDX_C94CE78638B81E49 ON tiene_seccion (restaurante_id)');
        $this->addSql('CREATE INDEX IDX_C94CE7867A5A413A ON tiene_seccion (seccion_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE guardar_imagen DROP FOREIGN KEY FK_10EE15A2763C8AA7');
        $this->addSql('ALTER TABLE guardar_imagen DROP FOREIGN KEY FK_10EE15A238B81E49');
        $this->addSql('DROP INDEX IDX_10EE15A2763C8AA7 ON guardar_imagen');
        $this->addSql('DROP INDEX IDX_10EE15A238B81E49 ON guardar_imagen');
        $this->addSql('ALTER TABLE guardar_imagen DROP imagen_id, DROP restaurante_id');
        $this->addSql('ALTER TABLE restaurante DROP FOREIGN KEY FK_5957C275DB38439E');
        $this->addSql('DROP INDEX IDX_5957C275DB38439E ON restaurante');
        $this->addSql('ALTER TABLE restaurante DROP usuario_id');
        $this->addSql('ALTER TABLE subir_imagen DROP FOREIGN KEY FK_8B95F4CBDB38439E');
        $this->addSql('ALTER TABLE subir_imagen DROP FOREIGN KEY FK_8B95F4CB763C8AA7');
        $this->addSql('DROP INDEX IDX_8B95F4CBDB38439E ON subir_imagen');
        $this->addSql('DROP INDEX IDX_8B95F4CB763C8AA7 ON subir_imagen');
        $this->addSql('ALTER TABLE subir_imagen DROP usuario_id, DROP imagen_id');
        $this->addSql('ALTER TABLE tiene_seccion DROP FOREIGN KEY FK_C94CE78638B81E49');
        $this->addSql('ALTER TABLE tiene_seccion DROP FOREIGN KEY FK_C94CE7867A5A413A');
        $this->addSql('DROP INDEX IDX_C94CE78638B81E49 ON tiene_seccion');
        $this->addSql('DROP INDEX IDX_C94CE7867A5A413A ON tiene_seccion');
        $this->addSql('ALTER TABLE tiene_seccion DROP restaurante_id, DROP seccion_id');
    }
}
