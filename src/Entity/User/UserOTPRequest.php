<?php

namespace App\Entity\User;

use App\Entity\Authentication\AuthUser;
use App\Entity\Base\BaseStatus;
use App\Repository\User\UserOTPRequestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserOTPRequestRepository::class)]
class UserOTPRequest extends BaseStatus
{
    const EXPIRE_INTERVAL = "+10 minutes";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?AuthUser $appUser = null;

    #[ORM\Column(length: 6)]
    private ?string $otp = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $requestedAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $expireAt = null;

    #[ORM\Column]
    private ?bool $isActivated = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $activatedAt = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $mode = null;

    #[ORM\Column(length: 12, nullable: true)]
    private ?string $mobileNumber = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $validTill = null;

    public function __construct()
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone(self::TIMEZONE));
        $expire = new \DateTimeImmutable(self::EXPIRE_INTERVAL, new \DateTimeZone(self::TIMEZONE));
        $this->requestedAt = $now;
        $this->expireAt = $expire;
        $this->isActivated = false;
        parent::__construct();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppUser(): ?AuthUser
    {
        return $this->appUser;
    }

    public function setAppUser(?AuthUser $appUser): static
    {
        $this->appUser = $appUser;

        return $this;
    }

    public function getOtp(): ?string
    {
        return $this->otp;
    }

    public function setOtp(string $otp): static
    {
        $this->otp = $otp;

        return $this;
    }

    public function getRequestedAt(): ?\DateTimeImmutable
    {
        return $this->requestedAt;
    }

    public function setRequestedAt(\DateTimeImmutable $requestedAt): static
    {
        $this->requestedAt = $requestedAt;

        return $this;
    }

    public function getExpireAt(): ?\DateTimeImmutable
    {
        return $this->expireAt;
    }

    public function setExpireAt(\DateTimeImmutable $expireAt): static
    {
        $this->expireAt = $expireAt;

        return $this;
    }

    public function isIsActivated(): ?bool
    {
        return $this->isActivated;
    }

    public function setIsActivated(bool $isActivated): static
    {
        $this->isActivated = $isActivated;

        return $this;
    }

    public function getActivatedAt(): ?\DateTimeImmutable
    {
        return $this->activatedAt;
    }

    public function setActivatedAt(?\DateTimeImmutable $activatedAt): static
    {
        $this->activatedAt = $activatedAt;

        return $this;
    }

    public function getMode(): ?string
    {
        return $this->mode;
    }

    public function setMode(?string $mode): static
    {
        $this->mode = $mode;

        return $this;
    }

    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    public function setMobileNumber(?string $mobileNumber): static
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }

    public function getValidTill(): ?\DateTimeImmutable
    {
        return $this->validTill;
    }

    public function setValidTill(?\DateTimeImmutable $validTill): static
    {
        $this->validTill = $validTill;

        return $this;
    }
}
