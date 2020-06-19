<?php
namespace App\Entity;

use App\Repository\OfertaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message="El campo no debe estar vacio.")
     * @Assert\Length(
     *      min = 1,
     *      max = 2,
     *      minMessage = "Descuento minimo {{ limit }}",
     *      maxMessage = "Descuento maximo"
     *      )
     */
    private $descuento;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="El campo no debe estar vacio.")
     * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "Minino de caracteres {{ limit }}",
     *      maxMessage = "Maximo de caracteres {{ limit }}"
     *      )
     */
    private $descripcion;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
    */
    private $fecha_hora;

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

    public function getFechaHora(): ?\DateTimeInterface
    {
        return $this->fecha_hora;
    }

    public function setFechaHora(\DateTimeInterface $fecha_hora): self
    {
        $this->fecha_hora = $fecha_hora;

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
