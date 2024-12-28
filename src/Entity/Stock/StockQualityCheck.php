<?php

namespace App\Entity\Stock;

use App\Entity\Authentication\AuthUser;
use App\Entity\Base\BaseFullRecord;
use App\Repository\Stock\StockQualityCheckRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockQualityCheckRepository::class)]
class StockQualityCheck extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stock $stock = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    #[ORM\Column]
    private ?int $checkVersion = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?AuthUser $performedBy = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?AuthUser $verifiedBy = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $checkDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $remark = null;

    #[ORM\Column]
    private ?float $marksGained = null;

    #[ORM\Column]
    private ?float $refferenceMaxMarks = null;

    #[ORM\Column(length: 20)]
    private ?string $qcStatus = null;

    public function __construct()
    {
        $this->uuid = strtoupper(uniqid("SQC_"));
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

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getCheckVersion(): ?int
    {
        return $this->checkVersion;
    }

    public function setCheckVersion(int $checkVersion): static
    {
        $this->checkVersion = $checkVersion;

        return $this;
    }

    public function getPerformedBy(): ?AuthUser
    {
        return $this->performedBy;
    }

    public function setPerformedBy(?AuthUser $performedBy): static
    {
        $this->performedBy = $performedBy;

        return $this;
    }

    public function getVerifiedBy(): ?AuthUser
    {
        return $this->verifiedBy;
    }

    public function setVerifiedBy(?AuthUser $verifiedBy): static
    {
        $this->verifiedBy = $verifiedBy;

        return $this;
    }

    public function getCheckDate(): ?\DateTimeImmutable
    {
        return $this->checkDate;
    }

    public function setCheckDate(\DateTimeImmutable $checkDate): static
    {
        $this->checkDate = $checkDate;

        return $this;
    }

    public function getRemark(): ?string
    {
        return $this->remark;
    }

    public function setRemark(?string $remark): static
    {
        $this->remark = $remark;

        return $this;
    }

    public function getMarksGained(): ?float
    {
        return $this->marksGained;
    }

    public function setMarksGained(float $marksGained): static
    {
        $this->marksGained = $marksGained;

        return $this;
    }

    public function getRefferenceMaxMarks(): ?float
    {
        return $this->refferenceMaxMarks;
    }

    public function setRefferenceMaxMarks(float $refferenceMaxMarks): static
    {
        $this->refferenceMaxMarks = $refferenceMaxMarks;

        return $this;
    }

    public function getQcStatus(): ?string
    {
        return $this->qcStatus;
    }

    public function setQcStatus(string $qcStatus): static
    {
        $this->qcStatus = $qcStatus;

        return $this;
    }
}
