<?php

namespace App\Entity;

use App\Repository\OfertaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OfertaRepository::class)
 */
class Oferta
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $descuento;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity=Promocion::class, mappedBy="oferta")
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

    public function getDescuento(): ?string
    {
        return $this->descuento;
    }

    public function setDescuento(string $descuento): self
    {
        $this->descuento = $descuento;

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
            $promocion->setOferta($this);
        }

        return $this;
    }

    public function removePromocion(Promocion $promocion): self
    {
        if ($this->promocion->contains($promocion)) {
            $this->promocion->removeElement($promocion);
            // set the owning side to null (unless already changed)
            if ($promocion->getOferta() === $this) {
                $promocion->setOferta(null);
            }
        }

        return $this;
    }
}
