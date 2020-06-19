<?php

namespace App\Entity;

use App\Repository\ResenaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ResenaRepository::class)
 */
class Resena
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $comentario;

    /**
     * @ORM\Column(type="float")
     */
    private $puntuacion;

    /**
     * @ORM\OneToMany(targetEntity=Comentar::class, mappedBy="resena")
     */
    private $comentar;

    public function __construct()
    {
        $this->comentar = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(string $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getPuntuacion(): ?float
    {
        return $this->puntuacion;
    }

    public function setPuntuacion(float $puntuacion): self
    {
        $this->puntuacion = $puntuacion;

        return $this;
    }

    /**
     * @return Collection|Comentar[]
     */
    public function getComentar(): Collection
    {
        return $this->comentar;
    }

    public function addComentar(Comentar $comentar): self
    {
        if (!$this->comentar->contains($comentar)) {
            $this->comentar[] = $comentar;
            $comentar->setResena($this);
        }

        return $this;
    }

    public function removeComentar(Comentar $comentar): self
    {
        if ($this->comentar->contains($comentar)) {
            $this->comentar->removeElement($comentar);
            // set the owning side to null (unless already changed)
            if ($comentar->getResena() === $this) {
                $comentar->setResena(null);
            }
        }

        return $this;
    }
}
