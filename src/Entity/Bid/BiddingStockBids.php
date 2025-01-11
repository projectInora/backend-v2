<?php

namespace App\Entity\Bid;

use App\Entity\Authentication\AuthUser;
use App\Entity\Base\BaseStatus;
use App\Repository\Bid\BiddingStockBidsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BiddingStockBidsRepository::class)]
class BiddingStockBids extends BaseStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?BiddingStock $biddingStock = null;

    #[ORM\ManyToOne(inversedBy: 'biddingStockBids')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AuthUser $bidBy = null;

    #[ORM\Column]
    private ?float $lastBidAmount = null;

    #[ORM\Column]
    private ?float $bidAmount = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $bidAt = null;

    #[ORM\Column]
    private ?int $sequenceNo = null;

    #[ORM\Column(nullable: true)]
    private ?int $lastBidId = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isWon = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBidBy(): ?AuthUser
    {
        return $this->bidBy;
    }

    public function setBidBy(?AuthUser $bidBy): static
    {
        $this->bidBy = $bidBy;

        return $this;
    }

    public function getLastBidAmount(): ?float
    {
        return $this->lastBidAmount;
    }

    public function setLastBidAmount(float $lastBidAmount): static
    {
        $this->lastBidAmount = $lastBidAmount;

        return $this;
    }

    public function getBidAmount(): ?float
    {
        return $this->bidAmount;
    }

    public function setBidAmount(float $bidAmount): static
    {
        $this->bidAmount = $bidAmount;

        return $this;
    }

    public function getBidAt(): ?\DateTimeImmutable
    {
        return $this->bidAt;
    }

    public function setBidAt(\DateTimeImmutable $bidAt): static
    {
        $this->bidAt = $bidAt;

        return $this;
    }

    public function getSequenceNo(): ?int
    {
        return $this->sequenceNo;
    }

    public function setSequenceNo(int $sequenceNo): static
    {
        $this->sequenceNo = $sequenceNo;

        return $this;
    }

    public function getLastBidId(): ?int
    {
        return $this->lastBidId;
    }

    public function setLastBidId(?int $lastBidId): static
    {
        $this->lastBidId = $lastBidId;

        return $this;
    }

    public function isWon(): ?bool
    {
        return $this->isWon;
    }

    public function setWon(?bool $isWon): static
    {
        $this->isWon = $isWon;

        return $this;
    }
}
