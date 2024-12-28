<?php

namespace App\Entity\Fishing;

use App\Entity\Authentication\AuthUser;
use App\Entity\Base\BaseFullRecord;
use App\Repository\Fishing\FishingCenterAdminsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FishingCenterAdminsRepository::class)]
class FishingCenterAdmins extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?FishingCenter $fishingCenter = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?AuthUser $centerAdmin = null;

    #[ORM\Column]
    private ?bool $isAccessAllowed = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFishingCenter(): ?FishingCenter
    {
        return $this->fishingCenter;
    }

    public function setFishingCenter(?FishingCenter $fishingCenter): static
    {
        $this->fishingCenter = $fishingCenter;

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
