<?php

namespace App\Entity\Bid;

use App\Entity\Base\BaseFullRecord;
use App\Repository\Bid\BiddingStockSummaryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BiddingStockSummaryRepository::class)]
class BiddingStockSummary extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?BiddingStockBids $stockBid = null;

    #[ORM\ManyToOne(inversedBy: 'biddingStockSummaries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BiddingStock $biddingStock = null;

    #[ORM\Column]
    private ?float $finalAmount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStockBid(): ?BiddingStockBids
    {
        return $this->stockBid;
    }

    public function setStockBid(?BiddingStockBids $stockBid): static
    {
        $this->stockBid = $stockBid;

        return $this;
    }

    public function getBiddingStock(): ?BiddingStock
    {
        return $this->biddingStock;
    }

    public function setBiddingStock(?BiddingStock $biddingStock): static
    {
        $this->biddingStock = $biddingStock;

        return $this;
    }

    public function getFinalAmount(): ?float
    {
        return $this->finalAmount;
    }

    public function setFinalAmount(float $finalAmount): static
    {
        $this->finalAmount = $finalAmount;

        return $this;
    }
}
