<?php

namespace App\Entity\Base;

use App\Entity\Authentication\AuthUser;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Exception;

#[ORM\MappedSuperclass]
class BaseRecord extends BaseStatus
{
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne]
    private ?AuthUser $createdBy = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne]
    private ?AuthUser $updatedBy = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $securityHash = null;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->updatedAt = new \DateTimeImmutable('now', new \DateTimeZone(self::TIMEZONE));
        $this->createdAt = new \DateTimeImmutable('now', new \DateTimeZone(self::TIMEZONE));
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getSecurityHash(): ?string
    {
        return $this->securityHash;
    }

    public function setSecurityHash(?string $securityHash): self
    {
        $this->securityHash = $securityHash;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedBy(): ?AuthUser
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?AuthUser $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function getUpdatedBy(): ?AuthUser
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?AuthUser $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }
}
