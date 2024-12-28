<?php

namespace App\Entity\Stock;

use App\Entity\Authentication\AuthUser;
use App\Entity\Base\BaseFullRecord;
use App\Entity\Boat\CatchingBoat;
use App\Entity\Fishing\FishingLocation;
use App\Entity\Landing\LandingPlace;
use App\Entity\Meta\Currency;
use App\Entity\Meta\FishType;
use App\Entity\Meta\FreezingMethod;
use App\Entity\Meta\PostHarvestTechnology;
use App\Entity\Product\FishProduct;
use App\Entity\User\UserSupplierCenter;
use App\Repository\Stock\StockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRepository::class)]
class Stock extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $stockNumber = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    #[ORM\ManyToOne]
    private ?FishType $fishType = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?FishProduct $fishProduct = null;

    #[ORM\ManyToOne]
    private ?FishingLocation $fishingLocation = null;

    #[ORM\ManyToOne]
    private ?CatchingBoat $boat = null;

    #[ORM\ManyToOne]
    private ?FreezingMethod $freezingMethod = null;

    #[ORM\Column]
    private ?float $totalStockQuantity = null;

    #[ORM\ManyToOne]
    private ?LandingPlace $landingPlace = null;

    #[ORM\Column]
    private ?float $stockTotalPrice = null;

    #[ORM\ManyToOne]
    private ?Currency $currencyType = null;

    #[ORM\ManyToOne]
    private ?PostHarvestTechnology $postHarvestingTechnology = null;

    #[ORM\ManyToOne]
    private ?StockAppearance $stockAppearance = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $temperature = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $colorOfFishSkin = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $melamineContent = null;

    #[ORM\Column]
    private ?bool $isHealthCertificateAvailable = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $healthCertificate = null;

    #[ORM\ManyToOne]
    private ?StockType $stockType = null;

    #[ORM\ManyToOne]
    private ?StockStatus $stockStatus = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $catchDate = null;

    #[ORM\Column(length: 50)]
    private ?string $batchCode = null;

    /**
     * @var Collection<int, StockSelling>
     */
    #[ORM\OneToMany(targetEntity: StockSelling::class, mappedBy: 'stock')]
    private Collection $stockSellings;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserSupplierCenter $supplierCenter = null;

    public function __construct()
    {
        parent::__construct();
        $this->uuid = strtoupper(uniqid("ST_"));
        $this->stockSellings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStockNumber(): ?string
    {
        return $this->stockNumber;
    }

    public function setStockNumber(string $stockNumber): static
    {
        $this->stockNumber = $stockNumber;

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

    public function getFishType(): ?FishType
    {
        return $this->fishType;
    }

    public function setFishType(?FishType $fishType): static
    {
        $this->fishType = $fishType;

        return $this;
    }

    public function getFishProduct(): ?FishProduct
    {
        return $this->fishProduct;
    }

    public function setFishProduct(?FishProduct $fishProduct): static
    {
        $this->fishProduct = $fishProduct;

        return $this;
    }

    public function getFishingLocation(): ?FishingLocation
    {
        return $this->fishingLocation;
    }

    public function setFishingLocation(?FishingLocation $fishingLocation): static
    {
        $this->fishingLocation = $fishingLocation;

        return $this;
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

    public function getTotalStockQuantity(): ?float
    {
        return $this->totalStockQuantity;
    }

    public function setTotalStockQuantity(float $totalStockQuantity): static
    {
        $this->totalStockQuantity = $totalStockQuantity;

        return $this;
    }

    public function getLandingPlace(): ?LandingPlace
    {
        return $this->landingPlace;
    }

    public function setLandingPlace(?LandingPlace $landingPlace): static
    {
        $this->landingPlace = $landingPlace;

        return $this;
    }

    public function getStockTotalPrice(): ?float
    {
        return $this->stockTotalPrice;
    }

    public function setStockTotalPrice(float $stockTotalPrice): static
    {
        $this->stockTotalPrice = $stockTotalPrice;

        return $this;
    }

    public function getCurrencyType(): ?Currency
    {
        return $this->currencyType;
    }

    public function setCurrencyType(?Currency $currencyType): static
    {
        $this->currencyType = $currencyType;

        return $this;
    }

    public function getPostHarvestingTechnology(): ?PostHarvestTechnology
    {
        return $this->postHarvestingTechnology;
    }

    public function setPostHarvestingTechnology(?PostHarvestTechnology $postHarvestingTechnology): static
    {
        $this->postHarvestingTechnology = $postHarvestingTechnology;

        return $this;
    }

    public function getStockAppearance(): ?StockAppearance
    {
        return $this->stockAppearance;
    }

    public function setStockAppearance(?StockAppearance $stockAppearance): static
    {
        $this->stockAppearance = $stockAppearance;

        return $this;
    }

    public function getTemperature(): ?string
    {
        return $this->temperature;
    }

    public function setTemperature(?string $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getColorOfFishSkin(): ?string
    {
        return $this->colorOfFishSkin;
    }

    public function setColorOfFishSkin(?string $colorOfFishSkin): static
    {
        $this->colorOfFishSkin = $colorOfFishSkin;

        return $this;
    }

    public function getMelamineContent(): ?string
    {
        return $this->melamineContent;
    }

    public function setMelamineContent(?string $melamineContent): static
    {
        $this->melamineContent = $melamineContent;

        return $this;
    }

    public function isHealthCertificateAvailable(): ?bool
    {
        return $this->isHealthCertificateAvailable;
    }

    public function setHealthCertificateAvailable(bool $isHealthCertificateAvailable): static
    {
        $this->isHealthCertificateAvailable = $isHealthCertificateAvailable;

        return $this;
    }

    public function getHealthCertificate(): ?string
    {
        return $this->healthCertificate;
    }

    public function setHealthCertificate(?string $healthCertificate): static
    {
        $this->healthCertificate = $healthCertificate;

        return $this;
    }

    public function getStockType(): ?StockType
    {
        return $this->stockType;
    }

    public function setStockType(?StockType $stockType): static
    {
        $this->stockType = $stockType;

        return $this;
    }

    public function getStockStatus(): ?StockStatus
    {
        return $this->stockStatus;
    }

    public function setStockStatus(?StockStatus $stockStatus): static
    {
        $this->stockStatus = $stockStatus;

        return $this;
    }

    public function getCatchDate(): ?\DateTimeImmutable
    {
        return $this->catchDate;
    }

    public function setCatchDate(\DateTimeImmutable $catchDate): static
    {
        $this->catchDate = $catchDate;

        return $this;
    }

    public function getBatchCode(): ?string
    {
        return $this->batchCode;
    }

    public function setBatchCode(string $batchCode): static
    {
        $this->batchCode = $batchCode;

        return $this;
    }

    /**
     * @return Collection<int, StockSelling>
     */
    public function getStockSellings(): Collection
    {
        return $this->stockSellings;
    }

    public function addStockSelling(StockSelling $stockSelling): static
    {
        if (!$this->stockSellings->contains($stockSelling)) {
            $this->stockSellings->add($stockSelling);
            $stockSelling->setStock($this);
        }

        return $this;
    }

    public function removeStockSelling(StockSelling $stockSelling): static
    {
        if ($this->stockSellings->removeElement($stockSelling)) {
            // set the owning side to null (unless already changed)
            if ($stockSelling->getStock() === $this) {
                $stockSelling->setStock(null);
            }
        }

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

    public function getSupplierCenter(): ?UserSupplierCenter
    {
        return $this->supplierCenter;
    }

    public function setSupplierCenter(?UserSupplierCenter $supplierCenter): static
    {
        $this->supplierCenter = $supplierCenter;

        return $this;
    }
}
