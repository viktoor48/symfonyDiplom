<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $number = null;

    #[ORM\Column(length: 20)]
    private ?string $gender = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: TimeSlot::class)]
    private Collection $timeSlots;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: ReviewClinic::class)]
    private Collection $reviewClinics;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: ReviewDoctor::class)]
    private Collection $reviewDoctors;

    public function __construct()
    {
        $this->timeSlots = new ArrayCollection();
        $this->reviewClinics = new ArrayCollection();
        $this->reviewDoctors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Collection<int, TimeSlot>
     */
    public function getTimeSlots(): Collection
    {
        return $this->timeSlots;
    }

    public function addTimeSlot(TimeSlot $timeSlot): self
    {
        if (!$this->timeSlots->contains($timeSlot)) {
            $this->timeSlots->add($timeSlot);
            $timeSlot->setClient($this);
        }

        return $this;
    }

    public function removeTimeSlot(TimeSlot $timeSlot): self
    {
        if ($this->timeSlots->removeElement($timeSlot)) {
            // set the owning side to null (unless already changed)
            if ($timeSlot->getClient() === $this) {
                $timeSlot->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReviewClinic>
     */
    public function getReviewClinics(): Collection
    {
        return $this->reviewClinics;
    }

    public function addReviewClinic(ReviewClinic $reviewClinic): self
    {
        if (!$this->reviewClinics->contains($reviewClinic)) {
            $this->reviewClinics->add($reviewClinic);
            $reviewClinic->setClient($this);
        }

        return $this;
    }

    public function removeReviewClinic(ReviewClinic $reviewClinic): self
    {
        if ($this->reviewClinics->removeElement($reviewClinic)) {
            // set the owning side to null (unless already changed)
            if ($reviewClinic->getClient() === $this) {
                $reviewClinic->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReviewDoctor>
     */
    public function getReviewDoctors(): Collection
    {
        return $this->reviewDoctors;
    }

    public function addReviewDoctor(ReviewDoctor $reviewDoctor): self
    {
        if (!$this->reviewDoctors->contains($reviewDoctor)) {
            $this->reviewDoctors->add($reviewDoctor);
            $reviewDoctor->setClient($this);
        }

        return $this;
    }

    public function removeReviewDoctor(ReviewDoctor $reviewDoctor): self
    {
        if ($this->reviewDoctors->removeElement($reviewDoctor)) {
            // set the owning side to null (unless already changed)
            if ($reviewDoctor->getClient() === $this) {
                $reviewDoctor->setClient(null);
            }
        }

        return $this;
    }
}
