<?php

namespace App\Entity\Fishing;

use App\Entity\Base\BaseFullRecord;
use App\Entity\Image\Images;
use App\Repository\Fishing\FishingCenterImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FishingCenterImagesRepository::class)]
class FishingCenterImages extends BaseFullRecord
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
    private ?Images $image = null;

    #[ORM\ManyToOne]
    private ?Images $mobileImage = null;

    #[ORM\Column]
    private ?int $displayOrder = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $validFrom = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $validTill = null;

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

    public function getImage(): ?Images
    {
        return $this->image;
    }

    public function setImage(?Images $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getMobileImage(): ?Images
    {
        return $this->mobileImage;
    }

    public function setMobileImage(?Images $mobileImage): static
    {
        $this->mobileImage = $mobileImage;

        return $this;
    }

    public function getDisplayOrder(): ?int
    {
        return $this->displayOrder;
    }

    public function setDisplayOrder(int $displayOrder): static
    {
        $this->displayOrder = $displayOrder;

        return $this;
    }

    public function getValidFrom(): ?\DateTimeImmutable
    {
        return $this->validFrom;
    }

    public function setValidFrom(?\DateTimeImmutable $validFrom): static
    {
        $this->validFrom = $validFrom;

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
