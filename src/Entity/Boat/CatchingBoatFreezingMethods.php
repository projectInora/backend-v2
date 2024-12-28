<?php

namespace App\Entity\Boat;

use App\Entity\Base\BaseFullRecord;
use App\Entity\Meta\FreezingMethod;
use App\Repository\Boat\CatchingBoatFreezingMethodsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CatchingBoatFreezingMethodsRepository::class)]
class CatchingBoatFreezingMethods extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?CatchingBoat $boat = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?FreezingMethod $freezingMethod = null;

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

    public function getFreezingMethod(): ?FreezingMethod
    {
        return $this->freezingMethod;
    }

    public function setFreezingMethod(?FreezingMethod $freezingMethod): static
    {
        $this->freezingMethod = $freezingMethod;

        return $this;
    }
}
