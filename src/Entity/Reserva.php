<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservaRepository")
 */
class Reserva
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="el campo no debe estar vacio.")
     */
    private $numero_personas;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    private $fecha;

    /**
     * @ORM\Column(type="time")
     * @Assert\NotBlank()
     */
    private $hora;

    /**
     * @ORM\ManyToOne(targetEntity=Usuario::class, inversedBy="reserva")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurante::class, inversedBy="reserva")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurante;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $realizada;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $puntos;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroPersonas(): ?int
    {
        return $this->numero_personas;
    }

    public function setNumeroPersonas(int $numero_personas): self
    {
        $this->numero_personas = $numero_personas;

        return $this;
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

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

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

    public function getRealizada(): ?string
    {
        return $this->realizada;
    }

    public function setRealizada(?string $realizada): self
    {
        $this->realizada = $realizada;

        return $this;
    }

    public function getPuntos(): ?int
    {
        return $this->puntos;
    }

    public function setPuntos(?int $puntos): self
    {
        $this->puntos = $puntos;

        return $this;
    }
}
