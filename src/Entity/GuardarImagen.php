<?php

namespace App\Entity;

use App\Repository\GuardarImagenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GuardarImagenRepository::class)
 */
class GuardarImagen
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_hora;

    /**
     * @ORM\ManyToOne(targetEntity=Imagen::class, inversedBy="guardarimagen")
     * @ORM\JoinColumn(nullable=false)
     */
    private $imagen;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurante::class, inversedBy="guardarimagen")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurante;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaHora(): ?\DateTimeInterface
    {
        return $this->fecha_hora;
    }

    public function setFechaHora(\DateTimeInterface $fecha_hora): self
    {
        $this->fecha_hora = $fecha_hora;

        return $this;
    }

    public function getImagen(): ?Imagen
    {
        return $this->imagen;
    }

    public function setImagen(?Imagen $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getRestaurante(): ?Restaurante
    {
        return $this->restaurante;
    }

    public function setRestaurante(?Restaurante $restaurante): self
    {
        $this->restaurante = $restaurante;

        return $this;
    }
}
