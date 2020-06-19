<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200530103209 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE reservar (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE datos CHANGE total_clientes total_clientes INT NOT NULL, CHANGE total_opiniones total_opiniones INT NOT NULL, CHANGE media_rest_puntuacion media_rest_puntuacion DOUBLE PRECISION NOT NULL, CHANGE reservas_canceladas reservas_canceladas INT NOT NULL, CHANGE reservas_aceptadas reservas_aceptadas INT NOT NULL');
        $this->addSql('ALTER TABLE informacion CHANGE apertura apertura VARCHAR(255) NOT NULL, CHANGE descripcion descripcion VARCHAR(255) NOT NULL, CHANGE servicios servicios VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reserva ADD realizada VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurante CHANGE datos_id datos_id INT NOT NULL, CHANGE informacion_id informacion_id INT NOT NULL, CHANGE ubicacion_id ubicacion_id INT NOT NULL, CHANGE usuario_id usuario_id INT NOT NULL, CHANGE nombre nombre VARCHAR(255) NOT NULL, CHANGE direccion direccion VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE telefono telefono VARCHAR(255) NOT NULL, CHANGE tipo tipo VARCHAR(50) NOT NULL, CHANGE favorito favorito TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE ubicacion CHANGE nombre_pais nombre_pais VARCHAR(30) NOT NULL, CHANGE provincia provincia VARCHAR(30) NOT NULL, CHANGE municipio municipio VARCHAR(30) NOT NULL, CHANGE longitud longitud DOUBLE PRECISION NOT NULL, CHANGE latitud latitud DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE usuario CHANGE imagen imagen VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05DE7927C74 ON usuario (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE reservar');
        $this->addSql('ALTER TABLE datos CHANGE total_clientes total_clientes INT DEFAULT NULL, CHANGE total_opiniones total_opiniones INT DEFAULT NULL, CHANGE media_rest_puntuacion media_rest_puntuacion DOUBLE PRECISION DEFAULT NULL, CHANGE reservas_canceladas reservas_canceladas INT DEFAULT NULL, CHANGE reservas_aceptadas reservas_aceptadas INT DEFAULT NULL');
        $this->addSql('ALTER TABLE informacion CHANGE apertura apertura VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE descripcion descripcion VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE servicios servicios VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reserva DROP realizada');
        $this->addSql('ALTER TABLE restaurante CHANGE datos_id datos_id INT DEFAULT NULL, CHANGE informacion_id informacion_id INT DEFAULT NULL, CHANGE ubicacion_id ubicacion_id INT DEFAULT NULL, CHANGE usuario_id usuario_id INT DEFAULT NULL, CHANGE nombre nombre VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE direccion direccion VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telefono telefono VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tipo tipo VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE favorito favorito TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE ubicacion CHANGE nombre_pais nombre_pais VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE provincia provincia VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE municipio municipio VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE longitud longitud DOUBLE PRECISION DEFAULT NULL, CHANGE latitud latitud DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_2265B05DE7927C74 ON usuario');
        $this->addSql('ALTER TABLE usuario CHANGE imagen imagen VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
