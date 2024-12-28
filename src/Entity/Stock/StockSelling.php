<?php

namespace App\Entity\Stock;

use App\Entity\Base\BaseFullRecord;
use App\Entity\Meta\SellingType;
use App\Repository\Stock\StockSellingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockSellingRepository::class)]
class StockSelling extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'stockSellings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stock $stock = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?SellingType $sellingType = null;

    #[ORM\Column]
    private ?float $totalStockQuantity = null;

    #[ORM\Column]
    private ?float $sellingMinQuantity = null;

    #[ORM\Column]
    private ?float $sellingMaxQuantity = null;

    #[ORM\Column(nullable: true)]
    private ?float $stepSize = null;

    #[ORM\Column]
    private ?float $unitPrice = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(?Stock $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getSellingType(): ?SellingType
    {
        return $this->sellingType;
    }

    public function setSellingType(?SellingType $sellingType): static
    {
        $this->sellingType = $sellingType;

        return $this;
    }

    public function getTotalStockQuantity(): ?float
    {
        return $this->totalStockQuantity;
    }

    public function setTotalStockQuantity(float $totalStockQuantity): static
    {
        $this->totalStockQuantity = $totalStockQuantity;

        return $this;
    }

    public function getSellingMinQuantity(): ?float
    {
        return $this->sellingMinQuantity;
    }

    public function setSellingMinQuantity(float $sellingMinQuantity): static
    {
        $this->sellingMinQuantity = $sellingMinQuantity;

        return $this;
    }

    public function getSellingMaxQuantity(): ?float
    {
        return $this->sellingMaxQuantity;
    }

    public function setSellingMaxQuantity(float $sellingMaxQuantity): static
    {
        $this->sellingMaxQuantity = $sellingMaxQuantity;

        return $this;
    }

    public function getStepSize(): ?float
    {
        return $this->stepSize;
    }

    public function setStepSize(?float $stepSize): static
    {
        $this->stepSize = $stepSize;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): static
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }
}
