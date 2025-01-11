<?php

namespace App\Entity\Product;

use App\Entity\Base\BaseFullRecord;
use App\Entity\FishDataSet\FishDataSet;
use App\Entity\Image\Images;
use App\Repository\Product\FishProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FishProductRepository::class)]
class FishProduct extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?FishDataSet $fishDataSet = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?array $nameVariations = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isActiveLive = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    #[ORM\ManyToOne]
    private ?Images $defaultImage = null;

    public function __construct()
    {
        parent::__construct();
        $this->uuid = strtoupper(uniqid('FSP_'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFishDataSet(): ?FishDataSet
    {
        return $this->fishDataSet;
    }

    public function setFishDataSet(?FishDataSet $fishDataSet): static
    {
        $this->fishDataSet = $fishDataSet;

        return $this;
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

    public function getNameVariations(): ?array
    {
        return $this->nameVariations;
    }

    public function setNameVariations(?array $nameVariations): static
    {
        $this->nameVariations = $nameVariations;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isActiveLive(): ?bool
    {
        return $this->isActiveLive;
    }

    public function setActiveLive(bool $isActiveLive): static
    {
        $this->isActiveLive = $isActiveLive;

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

    public function getDefaultImage(): ?Images
    {
        return $this->defaultImage;
    }

    public function setDefaultImage(?Images $defaultImage): static
    {
        $this->defaultImage = $defaultImage;

        return $this;
    }
}
