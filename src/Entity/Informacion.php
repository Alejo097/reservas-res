<?php

namespace App\Entity;

use App\Repository\InformacionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InformacionRepository::class)
 */
class Informacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $apertura;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $servicios;

    /**
     * @ORM\OneToMany(targetEntity=Restaurante::class, mappedBy="informacion")
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

    public function getApertura(): ?string
    {
        return $this->apertura;
    }

    public function setApertura(string $apertura): self
    {
        $this->apertura = $apertura;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getServicios(): ?string
    {
        return $this->servicios;
    }

    public function setServicios(string $servicios): self
    {
        $this->servicios = $servicios;

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
            $restaurante->setInformacion($this);
        }

        return $this;
    }

    public function removeRestaurante(Restaurante $restaurante): self
    {
        if ($this->restaurante->contains($restaurante)) {
            $this->restaurante->removeElement($restaurante);
            // set the owning side to null (unless already changed)
            if ($restaurante->getInformacion() === $this) {
                $restaurante->setInformacion(null);
            }
        }

        return $this;
    }
}
