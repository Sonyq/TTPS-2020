<?php

namespace App\Entity;

use App\Repository\CamaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CamaRepository::class)
 */
class Cama
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Sala::class, inversedBy="camas")
     */
    private $sala_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numero;

    /**
     * @ORM\OneToMany(targetEntity=InternacionCama::class, mappedBy="cama_id")
     */
    private $internacionCamas;

    public function __construct()
    {
        $this->internacionCamas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSalaId(): ?Sala
    {
        return $this->sala_id;
    }

    public function setSalaId(?Sala $sala_id): self
    {
        $this->sala_id = $sala_id;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return Collection|InternacionCama[]
     */
    public function getInternacionCamas(): Collection
    {
        return $this->internacionCamas;
    }

    public function addInternacionCama(InternacionCama $internacionCama): self
    {
        if (!$this->internacionCamas->contains($internacionCama)) {
            $this->internacionCamas[] = $internacionCama;
            $internacionCama->setCamaId($this);
        }

        return $this;
    }

    public function removeInternacionCama(InternacionCama $internacionCama): self
    {
        if ($this->internacionCamas->removeElement($internacionCama)) {
            // set the owning side to null (unless already changed)
            if ($internacionCama->getCamaId() === $this) {
                $internacionCama->setCamaId(null);
            }
        }

        return $this;
    }
}
