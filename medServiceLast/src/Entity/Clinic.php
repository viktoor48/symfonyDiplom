<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ClinicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClinicRepository::class)]
#[ApiResource]
class Clinic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $number = null;

    #[ORM\Column(length: 255)]
    private ?string $specialization = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'clinic', targetEntity: TimeSlot::class)]
    private Collection $timeSlots;

    #[ORM\ManyToMany(targetEntity: Doctor::class, inversedBy: 'clinics')]
    private Collection $doctor;

    #[ORM\OneToMany(mappedBy: 'clinic', targetEntity: ReviewClinic::class)]
    private Collection $reviewClinics;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    public function __construct()
    {
        $this->timeSlots = new ArrayCollection();
        $this->doctor = new ArrayCollection();
        $this->reviewClinics = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getSpecialization(): ?string
    {
        return $this->specialization;
    }

    public function setSpecialization(string $specialization): self
    {
        $this->specialization = $specialization;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

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
            $timeSlot->setClinic($this);
        }

        return $this;
    }

    public function removeTimeSlot(TimeSlot $timeSlot): self
    {
        if ($this->timeSlots->removeElement($timeSlot)) {
            // set the owning side to null (unless already changed)
            if ($timeSlot->getClinic() === $this) {
                $timeSlot->setClinic(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Doctor>
     */
    public function getDoctor(): Collection
    {
        return $this->doctor;
    }

    public function addDoctor(Doctor $doctor): self
    {
        if (!$this->doctor->contains($doctor)) {
            $this->doctor->add($doctor);
        }

        return $this;
    }

    public function removeDoctor(Doctor $doctor): self
    {
        $this->doctor->removeElement($doctor);

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
            $reviewClinic->setClinic($this);
        }

        return $this;
    }

    public function removeReviewClinic(ReviewClinic $reviewClinic): self
    {
        if ($this->reviewClinics->removeElement($reviewClinic)) {
            // set the owning side to null (unless already changed)
            if ($reviewClinic->getClinic() === $this) {
                $reviewClinic->setClinic(null);
            }
        }

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }
}
