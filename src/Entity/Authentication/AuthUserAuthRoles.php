<?php

namespace App\Entity\Authentication;

use App\Entity\Base\BaseFullRecord;
use App\Repository\Authentication\AuthUserAuthRolesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthUserAuthRolesRepository::class)]
class AuthUserAuthRoles extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?AuthUserRole $authRole = null;

    #[ORM\Column]
    private ?bool $isAccessAllowed = null;

    #[ORM\ManyToOne(inversedBy: 'authUserAuthRoles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AuthUser $authUser = null;

    public function __construct()
    {
        parent::__construct();
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

    public function getAuthRole(): ?AuthUserRole
    {
        return $this->authRole;
    }

    public function setAuthRole(?AuthUserRole $authRole): static
    {
        $this->authRole = $authRole;

        return $this;
    }

    public function isAccessAllowed(): ?bool
    {
        return $this->isAccessAllowed;
    }

    public function setAccessAllowed(bool $isAccessAllowed): static
    {
        $this->isAccessAllowed = $isAccessAllowed;

        return $this;
    }
}
