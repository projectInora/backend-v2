<?php

namespace App\Entity\User;

use App\Entity\Authentication\AuthUser;
use App\Entity\Base\BaseFullRecord;
use App\Entity\Fishing\FishingCenter;
use App\Repository\User\UserSupplierCenterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserSupplierCenterRepository::class)]
class UserSupplierCenter extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?AuthUser $supplier = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?FishingCenter $center = null;

    #[ORM\Column]
    private ?bool $isVerified = null;

    #[ORM\Column(nullable: false)]
    private ?\DateTimeImmutable $verifiedAt = null;

    #[ORM\ManyToOne]
    private ?AuthUser $verifiedBy = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSupplier(): ?AuthUser
    {
        return $this->supplier;
    }

    public function setSupplier(?AuthUser $supplier): static
    {
        $this->supplier = $supplier;

        return $this;
    }

    public function getCenter(): ?FishingCenter
    {
        return $this->center;
    }

    public function setCenter(?FishingCenter $center): static
    {
        $this->center = $center;

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

    public function setVerifiedAt(\DateTimeImmutable $verifiedAt): static
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
