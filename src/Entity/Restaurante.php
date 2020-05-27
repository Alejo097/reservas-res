<?php

namespace App\Entity;

use App\Repository\RestauranteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RestauranteRepository::class)
 */
class Restaurante
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
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $direccion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $tipo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $favorito;

    /**
     * @ORM\OneToMany(targetEntity=Reserva::class, mappedBy="restaurante")
     */
    private $reserva;

    /**
     * @ORM\ManyToOne(targetEntity=Datos::class, inversedBy="restaurante")
     * @ORM\JoinColumn(nullable=false)
     */
    private $datos;

    /**
     * @ORM\ManyToOne(targetEntity=Informacion::class, inversedBy="restaurante")
     * @ORM\JoinColumn(nullable=false)
     */
    private $informacion;

    /**
     * @ORM\OneToMany(targetEntity=Promocion::class, mappedBy="restaurante")
     */
    private $promocion;

    /**
     * @ORM\ManyToOne(targetEntity=Ubicacion::class, inversedBy="restaurante")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ubicacion;

    /**
     * @ORM\OneToMany(targetEntity=Comentar::class, mappedBy="restaurante")
     */
    private $comentar;

    /**
     * @ORM\OneToMany(targetEntity=TieneSeccion::class, mappedBy="restaurante")
     */
    private $seccion;

    /**
     * @ORM\OneToMany(targetEntity=GuardarImagen::class, mappedBy="restaurante")
     */
    private $guardarimagen;

    /**
     * @ORM\ManyToOne(targetEntity=Usuario::class, inversedBy="tienerestaurante")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    public function __construct()
    {
        $this->reserva = new ArrayCollection();
        $this->promocion = new ArrayCollection();
        $this->comentar = new ArrayCollection();
        $this->seccion = new ArrayCollection();
        $this->guardarimagen = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

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

    public function getFavorito(): ?bool
    {
        return $this->favorito;
    }

    public function setFavorito(bool $favorito): self
    {
        $this->favorito = $favorito;

        return $this;
    }

    /**
     * @return Collection|Reserva[]
     */
    public function getReserva(): Collection
    {
        return $this->reserva;
    }

    public function addReserva(Reserva $reserva): self
    {
        if (!$this->reserva->contains($reserva)) {
            $this->reserva[] = $reserva;
            $reserva->setRestaurante($this);
        }

        return $this;
    }

    public function removeReserva(Reserva $reserva): self
    {
        if ($this->reserva->contains($reserva)) {
            $this->reserva->removeElement($reserva);
            // set the owning side to null (unless already changed)
            if ($reserva->getRestaurante() === $this) {
                $reserva->setRestaurante(null);
            }
        }

        return $this;
    }

    public function getDatos(): ?Datos
    {
        return $this->datos;
    }

    public function setDatos(?Datos $datos): self
    {
        $this->datos = $datos;

        return $this;
    }

    public function getInformacion(): ?Informacion
    {
        return $this->informacion;
    }

    public function setInformacion(?Informacion $informacion): self
    {
        $this->informacion = $informacion;

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
            $promocion->setRestaurante($this);
        }

        return $this;
    }

    public function removePromocion(Promocion $promocion): self
    {
        if ($this->promocion->contains($promocion)) {
            $this->promocion->removeElement($promocion);
            // set the owning side to null (unless already changed)
            if ($promocion->getRestaurante() === $this) {
                $promocion->setRestaurante(null);
            }
        }

        return $this;
    }

    public function getUbicacion(): ?Ubicacion
    {
        return $this->ubicacion;
    }

    public function setUbicacion(?Ubicacion $ubicacion): self
    {
        $this->ubicacion = $ubicacion;

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
            $comentar->setRestaurante($this);
        }

        return $this;
    }

    public function removeComentar(Comentar $comentar): self
    {
        if ($this->comentar->contains($comentar)) {
            $this->comentar->removeElement($comentar);
            // set the owning side to null (unless already changed)
            if ($comentar->getRestaurante() === $this) {
                $comentar->setRestaurante(null);
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
            $seccion->setRestaurante($this);
        }

        return $this;
    }

    public function removeSeccion(TieneSeccion $seccion): self
    {
        if ($this->seccion->contains($seccion)) {
            $this->seccion->removeElement($seccion);
            // set the owning side to null (unless already changed)
            if ($seccion->getRestaurante() === $this) {
                $seccion->setRestaurante(null);
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
            $guardarimagen->setRestaurante($this);
        }

        return $this;
    }

    public function removeGuardarimagen(GuardarImagen $guardarimagen): self
    {
        if ($this->guardarimagen->contains($guardarimagen)) {
            $this->guardarimagen->removeElement($guardarimagen);
            // set the owning side to null (unless already changed)
            if ($guardarimagen->getRestaurante() === $this) {
                $guardarimagen->setRestaurante(null);
            }
        }

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }
}
