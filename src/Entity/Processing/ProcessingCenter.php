<?php

namespace App\Entity\Processing;

use App\Entity\Authentication\AuthUser;
use App\Entity\Base\BaseFullRecord;
use App\Repository\Processing\ProcessingCenterRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProcessingCenterRepository::class)]
class ProcessingCenter extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne]
    private ?AuthUser $centerAdmin = null;

    #[ORM\Column(length: 50)]
    private ?string $centerCode = null;

    #[ORM\Column]
    private ?bool $isVerified = null;

    #[ORM\ManyToOne]
    private ?AuthUser $verifiedBy = null;

    #[ORM\Column]
    private ?bool $isActiveLive = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private ?array $contactNos = null;

    public function __construct()
    {
        parent::__construct();
        $this->uuid = strtoupper(uniqid("PC_"));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCenterAdmin(): ?AuthUser
    {
        return $this->centerAdmin;
    }

    public function setCenterAdmin(?AuthUser $centerAdmin): static
    {
        $this->centerAdmin = $centerAdmin;

        return $this;
    }

    public function getCenterCode(): ?string
    {
        return $this->centerCode;
    }

    public function setCenterCode(string $centerCode): static
    {
        $this->centerCode = $centerCode;

        return $this;
    }

    public function isVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getVerifiedBy(): ?AuthUser
    {
        return $this->verifiedBy;
    }

    public function setVerifiedBy(?AuthUser $verifiedBy): static
    {
        $this->verifiedBy = $verifiedBy;

        return $this;
    }

    public function isActiveLive(): ?bool
    {
        return $this->isActiveLive;
    }

    public function setActiveLive(bool $isActiveLive): static
    {
        $this->isActiveLive = $isActiveLive;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getContactNos(): ?array
    {
        return $this->contactNos;
    }

    public function setContactNos(?array $contactNos): static
    {
        $this->contactNos = $contactNos;

        return $this;
    }
}
