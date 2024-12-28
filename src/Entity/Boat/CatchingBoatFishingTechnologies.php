<?php

namespace App\Entity\Boat;

use App\Entity\Base\BaseFullRecord;
use App\Entity\Meta\FishingTechnology;
use App\Repository\Boat\CatchingBoatFishingTechnologiesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CatchingBoatFishingTechnologiesRepository::class)]
class CatchingBoatFishingTechnologies extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CatchingBoat $boat = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?FishingTechnology $fishingTechnology = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBoat(): ?CatchingBoat
    {
        return $this->boat;
    }

    public function setBoat(?CatchingBoat $boat): static
    {
        $this->boat = $boat;

        return $this;
    }

    public function getFishingTechnology(): ?FishingTechnology
    {
        return $this->fishingTechnology;
    }

    public function setFishingTechnology(?FishingTechnology $fishingTechnology): static
    {
        $this->fishingTechnology = $fishingTechnology;

        return $this;
    }
}
