<?php

namespace App\Entity\Bid;

use App\Entity\Authentication\AuthUser;
use App\Entity\Base\BaseFullRecord;
use App\Entity\Stock\StockSelling;
use App\Repository\Bid\BiddingStockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BiddingStockRepository::class)]
class BiddingStock extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?StockSelling $stockSelling = null;

    #[ORM\Column(length: 20)]
    private ?string $batchNo = null;

    #[ORM\Column]
    private ?float $stockQuantity = null;

    #[ORM\Column]
    private ?float $startingPrice = null;

    #[ORM\Column]
    private ?float $minBidAmount = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $stockStartAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $stockEndBefore = null;

    #[ORM\Column]
    private ?bool $isStarted = null;

    #[ORM\Column]
    private ?bool $isEnded = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\Column(nullable: true)]
    private ?float $lastBidAmount = null;

    #[ORM\ManyToOne]
    private ?AuthUser $lastBidBy = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $lastBidAt = null;

    /**
     * @var Collection<int, BiddingStockSummary>
     */
    #[ORM\OneToMany(targetEntity: BiddingStockSummary::class, mappedBy: 'biddingStock')]
    private Collection $biddingStockSummaries;

    public function __construct()
    {
        parent::__construct();
        $this->biddingStockSummaries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStockSelling(): ?StockSelling
    {
        return $this->stockSelling;
    }

    public function setStockSelling(?StockSelling $stockSelling): static
    {
        $this->stockSelling = $stockSelling;

        return $this;
    }

    public function getBatchNo(): ?string
    {
        return $this->batchNo;
    }

    public function setBatchNo(string $batchNo): static
    {
        $this->batchNo = $batchNo;

        return $this;
    }

    public function getStockQuantity(): ?float
    {
        return $this->stockQuantity;
    }

    public function setStockQuantity(float $stockQuantity): static
    {
        $this->stockQuantity = $stockQuantity;

        return $this;
    }

    public function getStartingPrice(): ?float
    {
        return $this->startingPrice;
    }

    public function setStartingPrice(float $startingPrice): static
    {
        $this->startingPrice = $startingPrice;

        return $this;
    }

    public function getMinBidAmount(): ?float
    {
        return $this->minBidAmount;
    }

    public function setMinBidAmount(float $minBidAmount): static
    {
        $this->minBidAmount = $minBidAmount;

        return $this;
    }

    public function getStockStartAt(): ?\DateTimeImmutable
    {
        return $this->stockStartAt;
    }

    public function setStockStartAt(\DateTimeImmutable $stockStartAt): static
    {
        $this->stockStartAt = $stockStartAt;

        return $this;
    }

    public function getStockEndBefore(): ?\DateTimeImmutable
    {
        return $this->stockEndBefore;
    }

    public function setStockEndBefore(?\DateTimeImmutable $stockEndBefore): static
    {
        $this->stockEndBefore = $stockEndBefore;

        return $this;
    }

    public function isStarted(): ?bool
    {
        return $this->isStarted;
    }

    public function setStarted(bool $isStarted): static
    {
        $this->isStarted = $isStarted;

        return $this;
    }

    public function isEnded(): ?bool
    {
        return $this->isEnded;
    }

    public function setEnded(bool $isEnded): static
    {
        $this->isEnded = $isEnded;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getLastBidAmount(): ?float
    {
        return $this->lastBidAmount;
    }

    public function setLastBidAmount(?float $lastBidAmount): static
    {
        $this->lastBidAmount = $lastBidAmount;

        return $this;
    }

    public function getLastBidBy(): ?AuthUser
    {
        return $this->lastBidBy;
    }

    public function setLastBidBy(?AuthUser $lastBidBy): static
    {
        $this->lastBidBy = $lastBidBy;

        return $this;
    }

    public function getLastBidAt(): ?\DateTimeImmutable
    {
        return $this->lastBidAt;
    }

    public function setLastBidAt(\DateTimeImmutable $lastBidAt): static
    {
        $this->lastBidAt = $lastBidAt;

        return $this;
    }

    /**
     * @return Collection<int, BiddingStockSummary>
     */
    public function getBiddingStockSummaries(): Collection
    {
        return $this->biddingStockSummaries;
    }

    public function addBiddingStockSummary(BiddingStockSummary $biddingStockSummary): static
    {
        if (!$this->biddingStockSummaries->contains($biddingStockSummary)) {
            $this->biddingStockSummaries->add($biddingStockSummary);
            $biddingStockSummary->setBiddingStock($this);
        }

        return $this;
    }

    public function removeBiddingStockSummary(BiddingStockSummary $biddingStockSummary): static
    {
        if ($this->biddingStockSummaries->removeElement($biddingStockSummary)) {
            // set the owning side to null (unless already changed)
            if ($biddingStockSummary->getBiddingStock() === $this) {
                $biddingStockSummary->setBiddingStock(null);
            }
        }

        return $this;
    }
}
