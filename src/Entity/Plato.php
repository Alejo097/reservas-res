<?php

namespace App\Entity;

use App\Repository\PlatoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlatoRepository::class)
 */
class Plato
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $titulo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $precio;

    /**
     * @ORM\ManyToOne(targetEntity=Seccion::class, inversedBy="plato")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seccion;

    /**
     * @ORM\OneToMany(targetEntity=Promocion::class, mappedBy="plato")
     */
    private $promocion;

    public function __construct()
    {
        $this->promocion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

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

    public function getPrecio(): ?string
    {
        return $this->precio;
    }

    public function setPrecio(string $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getSeccion(): ?Seccion
    {
        return $this->seccion;
    }

    public function setSeccion(?Seccion $seccion): self
    {
        $this->seccion = $seccion;

        return $this;
    }

    /**
     * @return Collection|Promocion[]
     */
    public function getPromocion(): Collection
    {
        return $this->promocion;
    }

    public function addPromocion(Promocion $promocion): self
    {
        if (!$this->promocion->contains($promocion)) {
            $this->promocion[] = $promocion;
            $promocion->setPlato($this);
        }

        return $this;
    }

    public function removePromocion(Promocion $promocion): self
    {
        if ($this->promocion->contains($promocion)) {
            $this->promocion->removeElement($promocion);
            // set the owning side to null (unless already changed)
            if ($promocion->getPlato() === $this) {
                $promocion->setPlato(null);
            }
        }

        return $this;
    }
}
