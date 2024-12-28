<?php

namespace App\Entity\Stock;

use App\Entity\Authentication\AuthUser;
use App\Entity\Base\BaseRecord;
use App\Entity\QualityCheck\QualityCheckList;
use App\Repository\Stock\StockQualityCheckListRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockQualityCheckListRepository::class)]
class StockQualityCheckList extends BaseRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?StockQualityCheck $qualityCheck = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?QualityCheckList $checkList = null;

    #[ORM\Column]
    private ?float $marks = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?AuthUser $performedBy = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $performedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $remark = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQualityCheck(): ?StockQualityCheck
    {
        return $this->qualityCheck;
    }

    public function setQualityCheck(?StockQualityCheck $qualityCheck): static
    {
        $this->qualityCheck = $qualityCheck;

        return $this;
    }

    public function getCheckList(): ?QualityCheckList
    {
        return $this->checkList;
    }

    public function setCheckList(?QualityCheckList $checkList): static
    {
        $this->checkList = $checkList;

        return $this;
    }

    public function getMarks(): ?float
    {
        return $this->marks;
    }

    public function setMarks(float $marks): static
    {
        $this->marks = $marks;

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

    public function getPerformedAt(): ?\DateTimeImmutable
    {
        return $this->performedAt;
    }

    public function setPerformedAt(\DateTimeImmutable $performedAt): static
    {
        $this->performedAt = $performedAt;

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
}
