<?php

namespace App\Entity\CMS\Promo;

use App\Entity\Base\BaseFullRecord;
use App\Entity\CMS\Page\Page;
use App\Repository\CMS\Promo\PromoBarRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromoBarRepository::class)]
#[ORM\Table(name: "cms_promo_bar")]
class PromoBar extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $displayTitle = null;

    #[ORM\Column]
    private ?bool $isDisplayTitleVisible = null;

    #[ORM\Column]
    private ?bool $isSlidable = null;

    #[ORM\Column(length: 12)]
    private ?string $slideDirection = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subTitle = null;

    #[ORM\Column]
    private ?bool $isSubVisible = null;

    #[ORM\Column]
    private ?int $displayOrder = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $validFrom = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $validTill = null;

    #[ORM\Column]
    private ?int $contentPerRow = null;

    #[ORM\Column]
    private ?int $rowCountPerBar = null;

    #[ORM\Column]
    private ?float $cntDivAspectWidth = null;

    #[ORM\Column]
    private ?float $cntDivAspectHeight = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PromoType $promoType = null;

    #[ORM\ManyToOne(inversedBy: 'promoBars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Page $page = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDisplayTitle(): ?string
    {
        return $this->displayTitle;
    }

    public function setDisplayTitle(?string $displayTitle): static
    {
        $this->displayTitle = $displayTitle;

        return $this;
    }

    public function isDisplayTitleVisible(): ?bool
    {
        return $this->isDisplayTitleVisible;
    }

    public function setDisplayTitleVisible(bool $isDisplayTitleVisible): static
    {
        $this->isDisplayTitleVisible = $isDisplayTitleVisible;

        return $this;
    }

    public function isSlidable(): ?bool
    {
        return $this->isSlidable;
    }

    public function setSlidable(bool $isSlidable): static
    {
        $this->isSlidable = $isSlidable;

        return $this;
    }

    public function getSlideDirection(): ?string
    {
        return $this->slideDirection;
    }

    public function setSlideDirection(string $slideDirection): static
    {
        $this->slideDirection = $slideDirection;

        return $this;
    }

    public function getSubTitle(): ?string
    {
        return $this->subTitle;
    }

    public function setSubTitle(?string $subTitle): static
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    public function isSubVisible(): ?bool
    {
        return $this->isSubVisible;
    }

    public function setSubVisible(bool $isSubVisible): static
    {
        $this->isSubVisible = $isSubVisible;

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

    public function getContentPerRow(): ?int
    {
        return $this->contentPerRow;
    }

    public function setContentPerRow(int $contentPerRow): static
    {
        $this->contentPerRow = $contentPerRow;

        return $this;
    }

    public function getRowCountPerBar(): ?int
    {
        return $this->rowCountPerBar;
    }

    public function setRowCountPerBar(int $rowCountPerBar): static
    {
        $this->rowCountPerBar = $rowCountPerBar;

        return $this;
    }

    public function getCntDivAspectWidth(): ?float
    {
        return $this->cntDivAspectWidth;
    }

    public function setCntDivAspectWidth(float $cntDivAspectWidth): static
    {
        $this->cntDivAspectWidth = $cntDivAspectWidth;

        return $this;
    }

    public function getCntDivAspectHeight(): ?float
    {
        return $this->cntDivAspectHeight;
    }

    public function setCntDivAspectHeight(float $cntDivAspectHeight): static
    {
        $this->cntDivAspectHeight = $cntDivAspectHeight;

        return $this;
    }

    public function getPromoType(): ?PromoType
    {
        return $this->promoType;
    }

    public function setPromoType(?PromoType $promoType): static
    {
        $this->promoType = $promoType;

        return $this;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): static
    {
        $this->page = $page;

        return $this;
    }
}
