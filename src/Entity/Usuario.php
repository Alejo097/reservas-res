<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UsuarioRepository::class)
 * @UniqueEntity("email", message="Este correo ya esta registrado.")
 */
class Usuario implements UserInterface, \Serializable
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
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $apellido;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank(message="El campo no debe estar vacio.")
     * @Assert\Length(
     *      min = 8,
     *      max = 60,
     *      minMessage = "tu contraseña debe tener al menos {{ limit }} caracteres",
     *      maxMessage = "maximo de caracteres {{ limit }}",
     *)
     * 
     */
    private $contrasena;

    /**
     * @ORM\Column(name="email", type="string", length=60, unique=true)
     * @Assert\NotBlank(message="El campo no debe estar vacio.")
     * @Assert\Email(message="No es un correo valido.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(message="El campo no debe estar vacio.")
     * @Assert\Regex("/^(\+34|0034|34)?[ -]*(6|7)[ -]*([0-9][ -]*){8}$/",
     * message="Numero invalido.")
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Image(
     *     minWidth = 200,
     *     maxWidth = 600,
     *     minHeight = 200,
     *     maxHeight = 600
     * )
     */
    private $imagen;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $rol;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $puntos;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $restaurantes_favoritos;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $comentarios;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reservas;

    /**
     * @ORM\OneToMany(targetEntity=Reserva::class, mappedBy="usuario")
     */
    private $reserva;

    /**
     * @ORM\OneToMany(targetEntity=Comentar::class, mappedBy="usuario")
     */
    private $comentar;

    /**
     * @ORM\OneToMany(targetEntity=SubirImagen::class, mappedBy="usuario")
     */
    private $subirimagen;

    /**
     * @ORM\OneToMany(targetEntity=Restaurante::class, mappedBy="usuario")
     */
    private $tienerestaurante;

    public function __construct()
    {
        $this->reserva = new ArrayCollection();
        $this->comentar = new ArrayCollection();
        $this->subirimagen = new ArrayCollection();
        $this->tienerestaurante = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getContrasena(): ?string
    {
        return $this->contrasena;
    }

    public function setContrasena(string $contrasena): self
    {
        $this->contrasena = $contrasena;

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

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen($imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getRol(): ?string
    {
        return $this->rol;
    }

    public function setRol(string $rol): self
    {
        $this->rol = $rol;

        return $this;
    }

    public function getPuntos(): ?int
    {
        return $this->puntos;
    }

    public function setPuntos(?int $puntos): self
    {
        $this->puntos = $puntos;

        return $this;
    }

    public function getRestaurantesFavoritos(): ?int
    {
        return $this->restaurantes_favoritos;
    }

    public function setRestaurantesFavoritos(?int $restaurantes_favoritos): self
    {
        $this->restaurantes_favoritos = $restaurantes_favoritos;

        return $this;
    }

    public function getComentarios(): ?int
    {
        return $this->comentarios;
    }

    public function setComentarios(?int $comentarios): self
    {
        $this->comentarios = $comentarios;

        return $this;
    }

    public function getReservas(): ?int
    {
        return $this->reservas;
    }

    public function setReservas(?int $reservas): self
    {
        $this->reservas = $reservas;

        return $this;
    }

    //UserInterface fuerza estos 5 metodos (Sistema de seguridads)
    ##################################################################
    public function getUsername()
    {
        return $this->email;
    }

    public function getSalt()
    {
        // podrías necesitar un verdadero salt dependiendo del encoder
        return null;
    }

    public function getPassword()
    {
        return $this->contrasena;
    }

    public function getRoles()
    {
        return array($this->rol);
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize(
            array(
            $this->id,
            $this->email,
            $this->contrasena
        ));
    }

    public function unserialize($datos_serializados)
    {
        list(
            $this->id,
            $this->email, 
            $this->contrasena
            ) = unserialize($datos_serializados, array('allowed_classes' => false));
    }
    ##################################################

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
            $reserva->setUsuario($this);
        }

        return $this;
    }

    public function removeReserva(Reserva $reserva): self
    {
        if ($this->reserva->contains($reserva)) {
            $this->reserva->removeElement($reserva);
            // set the owning side to null (unless already changed)
            if ($reserva->getUsuario() === $this) {
                $reserva->setUsuario(null);
            }
        }

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
            $comentar->setUsuario($this);
        }

        return $this;
    }

    public function removeComentar(Comentar $comentar): self
    {
        if ($this->comentar->contains($comentar)) {
            $this->comentar->removeElement($comentar);
            // set the owning side to null (unless already changed)
            if ($comentar->getUsuario() === $this) {
                $comentar->setUsuario(null);
            }
        }

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
            $subirimagen->setUsuario($this);
        }

        return $this;
    }

    public function removeSubirimagen(SubirImagen $subirimagen): self
    {
        if ($this->subirimagen->contains($subirimagen)) {
            $this->subirimagen->removeElement($subirimagen);
            // set the owning side to null (unless already changed)
            if ($subirimagen->getUsuario() === $this) {
                $subirimagen->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Restaurante[]
     */
    public function getTienerestaurante(): Collection
    {
        return $this->tienerestaurante;
    }

    public function addTienerestaurante(Restaurante $tienerestaurante): self
    {
        if (!$this->tienerestaurante->contains($tienerestaurante)) {
            $this->tienerestaurante[] = $tienerestaurante;
            $tienerestaurante->setUsuario($this);
        }

        return $this;
    }

    public function removeTienerestaurante(Restaurante $tienerestaurante): self
    {
        if ($this->tienerestaurante->contains($tienerestaurante)) {
            $this->tienerestaurante->removeElement($tienerestaurante);
            // set the owning side to null (unless already changed)
            if ($tienerestaurante->getUsuario() === $this) {
                $tienerestaurante->setUsuario(null);
            }
        }

        return $this;
    }




}
