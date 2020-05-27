<?php

namespace App\Entity;

use App\Repository\DatosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DatosRepository::class)
 */
class Datos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $total_clientes;

    /**
     * @ORM\Column(type="integer")
     */
    private $total_opiniones;

    /**
     * @ORM\Column(type="float")
     */
    private $media_rest_puntuacion;

    /**
     * @ORM\Column(type="integer")
     */
    private $reservas_canceladas;

    /**
     * @ORM\Column(type="integer")
     */
    private $reservas_aceptadas;

    /**
     * @ORM\OneToMany(targetEntity=Restaurante::class, mappedBy="datos")
     */
    private $restaurante;

    public function __construct()
    {
        $this->restaurante = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalClientes(): ?int
    {
        return $this->total_clientes;
    }

    public function setTotalClientes(int $total_clientes): self
    {
        $this->total_clientes = $total_clientes;

        return $this;
    }

    public function getTotalOpiniones(): ?int
    {
        return $this->total_opiniones;
    }

    public function setTotalOpiniones(int $total_opiniones): self
    {
        $this->total_opiniones = $total_opiniones;

        return $this;
    }

    public function getMediaRestPuntuacion(): ?float
    {
        return $this->media_rest_puntuacion;
    }

    public function setMediaRestPuntuacion(float $media_rest_puntuacion): self
    {
        $this->media_rest_puntuacion = $media_rest_puntuacion;

        return $this;
    }

    public function getReservasCanceladas(): ?int
    {
        return $this->reservas_canceladas;
    }

    public function setReservasCanceladas(int $reservas_canceladas): self
    {
        $this->reservas_canceladas = $reservas_canceladas;

        return $this;
    }

    public function getReservasAceptadas(): ?int
    {
        return $this->reservas_aceptadas;
    }

    public function setReservasAceptadas(int $reservas_aceptadas): self
    {
        $this->reservas_aceptadas = $reservas_aceptadas;

        return $this;
    }

    /**
     * @return Collection|Restaurante[]
     */
    public function getRestaurante(): Collection
    {
        return $this->restaurante;
    }

    public function addRestaurante(Restaurante $restaurante): self
    {
        if (!$this->restaurante->contains($restaurante)) {
            $this->restaurante[] = $restaurante;
            $restaurante->setDatos($this);
        }

        return $this;
    }

    public function removeRestaurante(Restaurante $restaurante): self
    {
        if ($this->restaurante->contains($restaurante)) {
            $this->restaurante->removeElement($restaurante);
            // set the owning side to null (unless already changed)
            if ($restaurante->getDatos() === $this) {
                $restaurante->setDatos(null);
            }
        }

        return $this;
    }
}
