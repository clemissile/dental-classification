<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DiagnoseRepository")
 */
class Diagnose
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $patientName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $patientAge;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dentistName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $observations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $diagnoseType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPatientName(): ?string
    {
        return $this->patientName;
    }

    public function setPatientName(?string $patientName): self
    {
        $this->patientName = $patientName;

        return $this;
    }

    public function getPatientAge(): ?int
    {
        return $this->patientAge;
    }

    public function setPatientAge(?int $patientAge): self
    {
        $this->patientAge = $patientAge;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDentistName(): ?string
    {
        return $this->dentistName;
    }

    public function setDentistName(?string $dentistName): self
    {
        $this->dentistName = $dentistName;

        return $this;
    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations(?string $observations): self
    {
        $this->observations = $observations;

        return $this;
    }

    public function getDiagnoseType(): ?string
    {
        return $this->diagnoseType;
    }

    public function setDiagnoseType(?string $diagnoseType): self
    {
        $this->diagnoseType = $diagnoseType;

        return $this;
    }
}
