<?php

namespace App\Entity\Fishing;

use App\Entity\Base\BaseFullRecord;
use App\Entity\Base\BaseRecord;
use App\Entity\Meta\LocationSource;
use App\Entity\Meta\LocationType;
use App\Repository\Fishing\FishingLocationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FishingLocationRepository::class)]
class FishingLocation extends BaseRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?LocationSource $source = null;

    #[ORM\ManyToOne]
    private ?LocationType $locationType = null;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column]
    private ?float $northing = null;

    #[ORM\Column(length: 5)]
    private ?string $northingUnit = null;

    #[ORM\Column]
    private ?float $easting = null;

    #[ORM\Column(length: 5)]
    private ?string $eastingUnit = null;

    #[ORM\Column(nullable: true)]
    private ?float $headingDegree = null;

    #[ORM\Column(nullable: true)]
    private ?float $speed = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $speedUnit = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $locationTimeString = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource(): ?LocationSource
    {
        return $this->source;
    }

    public function setSource(?LocationSource $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getLocationType(): ?LocationType
    {
        return $this->locationType;
    }

    public function setLocationType(?LocationType $locationType): static
    {
        $this->locationType = $locationType;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getNorthing(): ?float
    {
        return $this->northing;
    }

    public function setNorthing(float $northing): static
    {
        $this->northing = $northing;

        return $this;
    }

    public function getNorthingUnit(): ?string
    {
        return $this->northingUnit;
    }

    public function setNorthingUnit(string $northingUnit): static
    {
        $this->northingUnit = $northingUnit;

        return $this;
    }

    public function getEasting(): ?float
    {
        return $this->easting;
    }

    public function setEasting(float $easting): static
    {
        $this->easting = $easting;

        return $this;
    }

    public function getEastingUnit(): ?string
    {
        return $this->eastingUnit;
    }

    public function setEastingUnit(string $eastingUnit): static
    {
        $this->eastingUnit = $eastingUnit;

        return $this;
    }

    public function getHeadingDegree(): ?float
    {
        return $this->headingDegree;
    }

    public function setHeadingDegree(?float $headingDegree): static
    {
        $this->headingDegree = $headingDegree;

        return $this;
    }

    public function getSpeed(): ?float
    {
        return $this->speed;
    }

    public function setSpeed(?float $speed): static
    {
        $this->speed = $speed;

        return $this;
    }

    public function getSpeedUnit(): ?string
    {
        return $this->speedUnit;
    }

    public function setSpeedUnit(?string $speedUnit): static
    {
        $this->speedUnit = $speedUnit;

        return $this;
    }

    public function getLocationTimeString(): ?string
    {
        return $this->locationTimeString;
    }

    public function setLocationTimeString(?string $locationTimeString): static
    {
        $this->locationTimeString = $locationTimeString;

        return $this;
    }
}
