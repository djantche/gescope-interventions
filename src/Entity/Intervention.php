<?php
namespace App\Entity;

use App\Repository\InterventionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterventionRepository::class)]
class Intervention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 100)]
    private string $reference;

    #[ORM\Column(type: "string", length: 100)]
    private string $firstName;

    #[ORM\Column(type: "string", length: 100)]
    private string $lastName;

    #[ORM\Column(type: "string", length: 255)]
    private string $address;

    #[ORM\Column(type: "string", length: 20)]
    private string $phone;

    #[ORM\Column(type: "string", length: 180)]
    private string $email;

    #[ORM\Column(type: "text")]
    private string $description;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $scheduledAt;

    #[ORM\Column(type: "string", length: 20)]
    private string $status = "en cours";

    #[ORM\Column(type: "string", length: 100)]
    private string $technician;

    // --- getters & setters (générer avec make:entity ou ton IDE) ---
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getReference(): string
    {
        return $this->reference;
    }
    public function setReference(string $r): self
    {
        $this->reference = $r;
        return $this;
    }
    public function getFirstName(): string
    {
        return $this->firstName;
    }
    public function setFirstName(string $v): self
    {
        $this->firstName = $v;
        return $this;
    }
    public function getLastName(): string
    {
        return $this->lastName;
    }
    public function setLastName(string $v): self
    {
        $this->lastName = $v;
        return $this;
    }
    public function getAddress(): string
    {
        return $this->address;
    }
    public function setAddress(string $v): self
    {
        $this->address = $v;
        return $this;
    }
    public function getPhone(): string
    {
        return $this->phone;
    }
    public function setPhone(string $v): self
    {
        $this->phone = $v;
        return $this;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $v): self
    {
        $this->email = $v;
        return $this;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(string $v): self
    {
        $this->description = $v;
        return $this;
    }
    public function getScheduledAt(): \DateTimeInterface
    {
        return $this->scheduledAt;
    }
    public function setScheduledAt(\DateTimeInterface $d): self
    {
        $this->scheduledAt = $d;
        return $this;
    }
    public function getStatus(): string
    {
        return $this->status;
    }
    public function setStatus(string $s): self
    {
        $this->status = $s;
        return $this;
    }
    public function getTechnician(): string
    {
        return $this->technician;
    }
    public function setTechnician(string $t): self
    {
        $this->technician = $t;
        return $this;
    }
}
