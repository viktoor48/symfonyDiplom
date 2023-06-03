<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReviewDoctorRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewDoctorRepository::class)]
#[ApiResource]
class ReviewDoctor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $liked = null;

    #[ORM\Column]
    private ?int $notLiked = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $advise = null;

    #[ORM\Column]
    private ?int $treatmentEffectivness = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $attitudeToPatient = null;

    #[ORM\ManyToOne(inversedBy: 'reviewDoctors')]
    private ?Doctor $doctor = null;

    #[ORM\ManyToOne(inversedBy: 'reviewDoctors')]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLiked(): ?int
    {
        return $this->liked;
    }

    public function setLiked(int $liked): self
    {
        $this->liked = $liked;

        return $this;
    }

    public function getNotLiked(): ?int
    {
        return $this->notLiked;
    }

    public function setNotLiked(int $notLiked): self
    {
        $this->notLiked = $notLiked;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAdvise(): ?int
    {
        return $this->advise;
    }

    public function setAdvise(int $advise): self
    {
        $this->advise = $advise;

        return $this;
    }

    public function getTreatmentEffectivness(): ?int
    {
        return $this->treatmentEffectivness;
    }

    public function setTreatmentEffectivness(int $treatmentEffectivness): self
    {
        $this->treatmentEffectivness = $treatmentEffectivness;

        return $this;
    }

    public function getAttitudeToPatient(): ?string
    {
        return $this->attitudeToPatient;
    }

    public function setAttitudeToPatient(?string $attitudeToPatient): self
    {
        $this->attitudeToPatient = $attitudeToPatient;

        return $this;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(?Doctor $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
