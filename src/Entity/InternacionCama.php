<?php

namespace App\Entity;

use App\Repository\InternacionCamaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InternacionCamaRepository::class)
 */
class InternacionCama
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Internacion::class, inversedBy="internacionCamas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $internacion_id;

    /**
     * @ORM\ManyToOne(targetEntity=Cama::class, inversedBy="internacionCamas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cama_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_desde;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $fecha_hasta;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInternacionId(): ?Internacion
    {
        return $this->internacion_id;
    }

    public function setInternacionId(?Internacion $internacion_id): self
    {
        $this->internacion_id = $internacion_id;

        return $this;
    }

    public function getCamaId(): ?Cama
    {
        return $this->cama_id;
    }

    public function setCamaId(?Cama $cama_id): self
    {
        $this->cama_id = $cama_id;

        return $this;
    }

    public function getFechaDesde(): ?\DateTimeInterface
    {
        return $this->fecha_desde;
    }

    public function setFechaDesde(\DateTimeInterface $fecha_desde): self
    {
        $this->fecha_desde = $fecha_desde;

        return $this;
    }

    public function getFechaHasta(): ?\DateTimeInterface
    {
        return $this->fecha_hasta;
    }

    public function setFechaHasta(?\DateTimeInterface $fecha_hasta): self
    {
        $this->fecha_hasta = $fecha_hasta;

        return $this;
    }
}
