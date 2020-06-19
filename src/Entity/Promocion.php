<?php

namespace App\Entity;

use App\Repository\PromocionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PromocionRepository::class)
 */
class Promocion 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Oferta::class, inversedBy="promocion")
     * @ORM\JoinColumn(nullable=false)
     */
    private $oferta;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurante::class, inversedBy="promocion")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurante;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOferta(): ?Oferta
    {
        return $this->oferta;
    }

    public function setOferta(?Oferta $oferta): self
    {
        $this->oferta = $oferta;

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
}
