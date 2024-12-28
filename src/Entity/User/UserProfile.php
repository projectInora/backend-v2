<?php

namespace App\Entity\User;

use App\Entity\Authentication\AuthUser;
use App\Entity\Base\BaseFullRecord;
use App\Entity\Meta\ProfileType;
use App\Repository\User\UserProfileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserProfileRepository::class)]
class UserProfile extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?AuthUser $authUser = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProfileType $profileType = null;

    #[ORM\ManyToOne]
    private ?UserProfileAddresses $defaultDeliveryAddress = null;

    #[ORM\ManyToOne]
    private ?UserProfileAddresses $defaultBillingAddress = null;

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

    public function getProfileType(): ?ProfileType
    {
        return $this->profileType;
    }

    public function setProfileType(?ProfileType $profileType): static
    {
        $this->profileType = $profileType;

        return $this;
    }

    public function getDefaultDeliveryAddress(): ?UserProfileAddresses
    {
        return $this->defaultDeliveryAddress;
    }

    public function setDefaultDeliveryAddress(?UserProfileAddresses $defaultDeliveryAddress): static
    {
        $this->defaultDeliveryAddress = $defaultDeliveryAddress;

        return $this;
    }

    public function getDefaultBillingAddress(): ?UserProfileAddresses
    {
        return $this->defaultBillingAddress;
    }

    public function setDefaultBillingAddress(?UserProfileAddresses $defaultBillingAddress): static
    {
        $this->defaultBillingAddress = $defaultBillingAddress;

        return $this;
    }
}
