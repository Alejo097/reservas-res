<?php

namespace App\Entity;

use App\Repository\ComentarRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComentarRepository::class)
 */
class Comentar
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="time")
     */
    private $hora;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurante::class, inversedBy="comentar")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurante;

    /**
     * @ORM\ManyToOne(targetEntity=Resena::class, inversedBy="comentar")
     * @ORM\JoinColumn(nullable=false)
     */
    private $resena;

    /**
     * @ORM\ManyToOne(targetEntity=Usuario::class, inversedBy="comentar")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHora(): ?\DateTimeInterface
    {
        return $this->hora;
    }

    public function setHora(\DateTimeInterface $hora): self
    {
        $this->hora = $hora;

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

    public function getResena(): ?Resena
    {
        return $this->resena;
    }

    public function setResena(?Resena $resena): self
    {
        $this->resena = $resena;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }
}
