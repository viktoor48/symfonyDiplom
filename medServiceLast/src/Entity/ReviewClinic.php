<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReviewClinicRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewClinicRepository::class)]
#[ApiResource]
class ReviewClinic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $liked = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $notLiked = null;

    #[ORM\Column]
    private ?int $attitudeMedStaff = null;

    #[ORM\Column]
    private ?int $waitingTime = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'reviewClinics')]
    private ?Clinic $clinic = null;

    #[ORM\ManyToOne(inversedBy: 'reviewClinics')]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLiked(): ?string
    {
        return $this->liked;
    }

    public function setLiked(?string $liked): self
    {
        $this->liked = $liked;

        return $this;
    }

    public function getNotLiked(): ?string
    {
        return $this->notLiked;
    }

    public function setNotLiked(?string $notLiked): self
    {
        $this->notLiked = $notLiked;

        return $this;
    }

    public function getAttitudeMedStaff(): ?int
    {
        return $this->attitudeMedStaff;
    }

    public function setAttitudeMedStaff(int $attitudeMedStaff): self
    {
        $this->attitudeMedStaff = $attitudeMedStaff;

        return $this;
    }

    public function getWaitingTime(): ?int
    {
        return $this->waitingTime;
    }

    public function setWaitingTime(int $waitingTime): self
    {
        $this->waitingTime = $waitingTime;

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

    public function getClinic(): ?Clinic
    {
        return $this->clinic;
    }

    public function setClinic(?Clinic $clinic): self
    {
        $this->clinic = $clinic;

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
