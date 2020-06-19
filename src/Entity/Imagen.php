<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ImagenRepository::class)
 */
class Imagen
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Image(
     *     minWidth = 200,
     *     maxWidth = 1080,
     *     minHeight = 200,
     *     maxHeight = 600)
     */
    private $imagen;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $tipo;

    /**
     * @ORM\OneToMany(targetEntity=SubirImagen::class, mappedBy="imagen")
     */
    private $subirimagen;

    /**
     * @ORM\OneToMany(targetEntity=GuardarImagen::class, mappedBy="imagen")
     */
    private $guardarimagen;

    public function __construct()
    {
        $this->subirimagen = new ArrayCollection();
        $this->guardarimagen = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * @return Collection|SubirImagen[]
     */
    public function getSubirimagen(): Collection
    {
        return $this->subirimagen;
    }

    public function addSubirimagen(SubirImagen $subirimagen): self
    {
        if (!$this->subirimagen->contains($subirimagen)) {
            $this->subirimagen[] = $subirimagen;
            $subirimagen->setImagen($this);
        }

        return $this;
    }

    public function removeSubirimagen(SubirImagen $subirimagen): self
    {
        if ($this->subirimagen->contains($subirimagen)) {
            $this->subirimagen->removeElement($subirimagen);
            // set the owning side to null (unless already changed)
            if ($subirimagen->getImagen() === $this) {
                $subirimagen->setImagen(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GuardarImagen[]
     */
    public function getGuardarimagen(): Collection
    {
        return $this->guardarimagen;
    }

    public function addGuardarimagen(GuardarImagen $guardarimagen): self
    {
        if (!$this->guardarimagen->contains($guardarimagen)) {
            $this->guardarimagen[] = $guardarimagen;
            $guardarimagen->setImagen($this);
        }

        return $this;
    }

    public function removeGuardarimagen(GuardarImagen $guardarimagen): self
    {
        if ($this->guardarimagen->contains($guardarimagen)) {
            $this->guardarimagen->removeElement($guardarimagen);
            // set the owning side to null (unless already changed)
            if ($guardarimagen->getImagen() === $this) {
                $guardarimagen->setImagen(null);
            }
        }

        return $this;
    }
}
