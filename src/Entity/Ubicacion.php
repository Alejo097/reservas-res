<?php

namespace App\Entity;

use App\Repository\UbicacionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UbicacionRepository::class)
 */
class Ubicacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nombre_pais;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $provincia;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $municipio;

    /**
     * @ORM\Column(type="float")
     */
    private $longitud;

    /**
     * @ORM\Column(type="float")
     */
    private $latitud;

    /**
     * @ORM\OneToMany(targetEntity=Restaurante::class, mappedBy="ubicacion")
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

    public function getNombrePais(): ?string
    {
        return $this->nombre_pais;
    }

    public function setNombrePais(string $nombre_pais): self
    {
        $this->nombre_pais = $nombre_pais;

        return $this;
    }

    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    public function setProvincia(string $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getMunicipio(): ?string
    {
        return $this->municipio;
    }

    public function setMunicipio(string $municipio): self
    {
        $this->municipio = $municipio;

        return $this;
    }

    public function getLongitud(): ?float
    {
        return $this->longitud;
    }

    public function setLongitud(float $longitud): self
    {
        $this->longitud = $longitud;

        return $this;
    }

    public function getLatitud(): ?float
    {
        return $this->latitud;
    }

    public function setLatitud(float $latitud): self
    {
        $this->latitud = $latitud;

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
            $restaurante->setUbicacion($this);
        }

        return $this;
    }

    public function removeRestaurante(Restaurante $restaurante): self
    {
        if ($this->restaurante->contains($restaurante)) {
            $this->restaurante->removeElement($restaurante);
            // set the owning side to null (unless already changed)
            if ($restaurante->getUbicacion() === $this) {
                $restaurante->setUbicacion(null);
            }
        }

        return $this;
    }
}
