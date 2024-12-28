<?php

namespace App\Entity\Boat;

use App\Entity\Authentication\AuthUser;
use App\Entity\Base\BaseFullRecord;
use App\Entity\Meta\BoatType;
use App\Repository\Boat\CatchingBoatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CatchingBoatRepository::class)]
class CatchingBoat extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?array $otherNames = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?BoatType $boatType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $registrationNo = null;

    #[ORM\ManyToOne]
    private ?AuthUser $owner = null;

    #[ORM\Column]
    private ?bool $isVerified = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $verifiedAt = null;

    #[ORM\ManyToOne]
    private ?AuthUser $verifiedBy = null;

    public function __construct()
    {
        $this->uuid = strtoupper(uniqid("CB_"));
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getOtherNames(): ?array
    {
        return $this->otherNames;
    }

    public function setOtherNames(?array $otherNames): static
    {
        $this->otherNames = $otherNames;

        return $this;
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

    public function getBoatType(): ?BoatType
    {
        return $this->boatType;
    }

    public function setBoatType(?BoatType $boatType): static
    {
        $this->boatType = $boatType;

        return $this;
    }

    public function getRegistrationNo(): ?string
    {
        return $this->registrationNo;
    }

    public function setRegistrationNo(?string $registrationNo): static
    {
        $this->registrationNo = $registrationNo;

        return $this;
    }

    public function getOwner(): ?AuthUser
    {
        return $this->owner;
    }

    public function setOwner(?AuthUser $owner): static
    {
        $this->owner = $owner;

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

    public function getVerifiedAt(): ?\DateTimeImmutable
    {
        return $this->verifiedAt;
    }

    public function setVerifiedAt(?\DateTimeImmutable $verifiedAt): static
    {
        $this->verifiedAt = $verifiedAt;

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
}
