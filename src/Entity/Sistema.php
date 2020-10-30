<?php

namespace App\Entity;

use App\Repository\SistemaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SistemaRepository::class)
 */
class Sistema
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descrip;

    /**
     * @ORM\Column(type="integer")
     */
    private $camas_total;

    /**
     * @ORM\Column(type="integer")
     */
    private $camas_disponibles;

    /**
     * @ORM\Column(type="integer")
     */
    private $camas_ocupadas;

    /**
     * @ORM\OneToMany(targetEntity=Sala::class, mappedBy="sistema_id")
     */
    private $salas;

    /**
     * @ORM\OneToMany(targetEntity=UserSistema::class, mappedBy="sistema_id")
     */
    private $userSistemas;

    public function __construct()
    {
        $this->salas = new ArrayCollection();
        $this->userSistemas = new ArrayCollection();
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

    public function getDescrip(): ?string
    {
        return $this->descrip;
    }

    public function setDescrip(?string $descrip): self
    {
        $this->descrip = $descrip;

        return $this;
    }

    public function getCamasTotal(): ?int
    {
        return $this->camas_total;
    }

    public function setCamasTotal(int $camas_total): self
    {
        $this->camas_total = $camas_total;

        return $this;
    }

    public function getCamasDisponibles(): ?int
    {
        return $this->camas_disponibles;
    }

    public function setCamasDisponibles(int $camas_disponibles): self
    {
        $this->camas_disponibles = $camas_disponibles;

        return $this;
    }

    public function getCamasOcupadas(): ?int
    {
        return $this->camas_ocupadas;
    }

    public function setCamasOcupadas(int $camas_ocupadas): self
    {
        $this->camas_ocupadas = $camas_ocupadas;

        return $this;
    }

    /**
     * @return Collection|Sala[]
     */
    public function getSalas(): Collection
    {
        return $this->salas;
    }

    public function addSala(Sala $sala): self
    {
        if (!$this->salas->contains($sala)) {
            $this->salas[] = $sala;
            $sala->setSistemaId($this);
        }

        return $this;
    }

    public function removeSala(Sala $sala): self
    {
        if ($this->salas->removeElement($sala)) {
            // set the owning side to null (unless already changed)
            if ($sala->getSistemaId() === $this) {
                $sala->setSistemaId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserSistema[]
     */
    public function getUserSistemas(): Collection
    {
        return $this->userSistemas;
    }

    public function addUserSistema(UserSistema $userSistema): self
    {
        if (!$this->userSistemas->contains($userSistema)) {
            $this->userSistemas[] = $userSistema;
            $userSistema->setSistemaId($this);
        }

        return $this;
    }

    public function removeUserSistema(UserSistema $userSistema): self
    {
        if ($this->userSistemas->removeElement($userSistema)) {
            // set the owning side to null (unless already changed)
            if ($userSistema->getSistemaId() === $this) {
                $userSistema->setSistemaId(null);
            }
        }

        return $this;
    }

}
