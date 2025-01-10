<?php

namespace App\Entity\Authentication;

use App\Entity\Base\BaseRecord;
use App\Entity\Base\BaseStatus;
use App\Repository\Authentication\AuthUserTokenAccessRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use League\Bundle\OAuth2ServerBundle\Model\AccessToken;

#[ORM\Entity(repositoryClass: AuthUserTokenAccessRepository::class)]
class AuthUserTokenAccess extends BaseStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?AuthUser $authUser = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $token = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $forceRevokedAt = null;

    #[ORM\ManyToOne]
    private ?AuthUser $forceRevokedBy = null;

    public function __construct()
    {
        parent::__construct();
        $this->createdAt = new \DateTimeImmutable('now', new \DateTimeZone(self::TIMEZONE));
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthUser(): ?AuthUser
    {
        return $this->authUser;
    }

    public function setAuthUser(?AuthUser $authUser): static
    {
        $this->authUser = $authUser;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getForceRevokedAt(): ?\DateTimeImmutable
    {
        return $this->forceRevokedAt;
    }

    public function setForceRevokedAt(\DateTimeImmutable $forceRevokedAt): static
    {
        $this->forceRevokedAt = $forceRevokedAt;

        return $this;
    }

    public function getForceRevokedBy(): ?AuthUser
    {
        return $this->forceRevokedBy;
    }

    public function setForceRevokedBy(?AuthUser $forceRevokedBy): static
    {
        $this->forceRevokedBy = $forceRevokedBy;

        return $this;
    }
}
