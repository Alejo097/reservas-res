<?php

namespace App\Entity;

use App\Repository\SeccionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SeccionRepository::class)
 */
class Seccion
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
     * @ORM\OneToMany(targetEntity=Plato::class, mappedBy="seccion")
     */
    private $plato;

    /**
     * @ORM\OneToMany(targetEntity=TieneSeccion::class, mappedBy="seccion")
     */
    private $seccion;

    public function __construct()
    {
        $this->plato = new ArrayCollection();
        $this->seccion = new ArrayCollection();
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

    /**
     * @return Collection|Plato[]
     */
    public function getPlato(): Collection
    {
        return $this->plato;
    }

    public function addPlato(Plato $plato): self
    {
        if (!$this->plato->contains($plato)) {
            $this->plato[] = $plato;
            $plato->setSeccion($this);
        }

        return $this;
    }

    public function removePlato(Plato $plato): self
    {
        if ($this->plato->contains($plato)) {
            $this->plato->removeElement($plato);
            // set the owning side to null (unless already changed)
            if ($plato->getSeccion() === $this) {
                $plato->setSeccion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TieneSeccion[]
     */
    public function getSeccion(): Collection
    {
        return $this->seccion;
    }

    public function addSeccion(TieneSeccion $seccion): self
    {
        if (!$this->seccion->contains($seccion)) {
            $this->seccion[] = $seccion;
            $seccion->setSeccion($this);
        }

        return $this;
    }

    public function removeSeccion(TieneSeccion $seccion): self
    {
        if ($this->seccion->contains($seccion)) {
            $this->seccion->removeElement($seccion);
            // set the owning side to null (unless already changed)
            if ($seccion->getSeccion() === $this) {
                $seccion->setSeccion(null);
            }
        }

        return $this;
    }
}
