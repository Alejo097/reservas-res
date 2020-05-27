<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200525160950 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comentar (id INT AUTO_INCREMENT NOT NULL, fecha DATE NOT NULL, hora TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE datos (id INT AUTO_INCREMENT NOT NULL, total_clientes INT NOT NULL, total_opiniones INT NOT NULL, media_rest_puntuacion DOUBLE PRECISION NOT NULL, reservas_canceladas INT NOT NULL, reservas_aceptadas INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guardar_imagen (id INT AUTO_INCREMENT NOT NULL, fecha_hora DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE imagen (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, imagen VARCHAR(255) NOT NULL, tipo VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE informacion (id INT AUTO_INCREMENT NOT NULL, apertura VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, servicios VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oferta (id INT AUTO_INCREMENT NOT NULL, descuento VARCHAR(20) NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plato (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(50) NOT NULL, descripcion VARCHAR(255) NOT NULL, precio VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promocion (id INT AUTO_INCREMENT NOT NULL, fecha DATE NOT NULL, hora TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resena (id INT AUTO_INCREMENT NOT NULL, comentario VARCHAR(255) NOT NULL, puntuacion DOUBLE PRECISION NOT NULL, fecha_hora DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reserva (id INT AUTO_INCREMENT NOT NULL, numero_personas INT NOT NULL, fecha DATE NOT NULL, hora TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurante (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, direccion VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telefono VARCHAR(255) NOT NULL, tipo VARCHAR(50) NOT NULL, favorito TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seccion (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subir_imagen (id INT AUTO_INCREMENT NOT NULL, fecha_hora DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tiene_seccion (id INT AUTO_INCREMENT NOT NULL, fecha_hora DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ubicacion (id INT AUTO_INCREMENT NOT NULL, nombre_pais VARCHAR(30) NOT NULL, provincia VARCHAR(30) NOT NULL, municipio VARCHAR(30) NOT NULL, longitud DOUBLE PRECISION NOT NULL, latitud DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(20) NOT NULL, apellido VARCHAR(20) NOT NULL, contrasena VARCHAR(60) NOT NULL, email VARCHAR(60) NOT NULL, telefono VARCHAR(20) NOT NULL, imagen VARCHAR(255) NOT NULL, rol VARCHAR(20) NOT NULL, puntos INT DEFAULT NULL, restaurantes_favoritos INT DEFAULT NULL, comentarios INT DEFAULT NULL, reservas INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE comentar');
        $this->addSql('DROP TABLE datos');
        $this->addSql('DROP TABLE guardar_imagen');
        $this->addSql('DROP TABLE imagen');
        $this->addSql('DROP TABLE informacion');
        $this->addSql('DROP TABLE oferta');
        $this->addSql('DROP TABLE plato');
        $this->addSql('DROP TABLE promocion');
        $this->addSql('DROP TABLE resena');
        $this->addSql('DROP TABLE reserva');
        $this->addSql('DROP TABLE restaurante');
        $this->addSql('DROP TABLE seccion');
        $this->addSql('DROP TABLE subir_imagen');
        $this->addSql('DROP TABLE tiene_seccion');
        $this->addSql('DROP TABLE ubicacion');
        $this->addSql('DROP TABLE usuario');
    }
}
