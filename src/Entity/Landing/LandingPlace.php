<?php

namespace App\Entity\Landing;

use App\Entity\Base\BaseAddressRecord;
use App\Entity\Meta\LandingCondition;
use App\Entity\Meta\LandingSiteType;
use App\Repository\Landing\LandingPlaceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LandingPlaceRepository::class)]
class LandingPlace extends BaseAddressRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?LandingSiteType $placeType = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?LandingCondition $siteCondition = null;

    public function __construct()
    {
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

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getPlaceType(): ?LandingSiteType
    {
        return $this->placeType;
    }

    public function setPlaceType(?LandingSiteType $placeType): static
    {
        $this->placeType = $placeType;

        return $this;
    }

    public function getSiteCondition(): ?LandingCondition
    {
        return $this->siteCondition;
    }

    public function setSiteCondition(?LandingCondition $siteCondition): static
    {
        $this->siteCondition = $siteCondition;

        return $this;
    }
}
