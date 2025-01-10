<?php

namespace App\Entity\CMS\Promo;

use App\Entity\Base\BaseFullRecord;
use App\Entity\CMS\Base\ButtonContent;
use App\Entity\Image\Images;
use App\Repository\CMS\Promo\PromoBarContentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromoBarContentRepository::class)]
#[ORM\Table(name: "cms_promo_bar_content")]
class PromoBarContent extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PromoBar $promoBar = null;

    #[ORM\Column]
    private ?int $displayOrder = null;

    #[ORM\ManyToOne]
    private ?Images $defaultBanner = null;

    #[ORM\ManyToOne]
    private ?Images $defaultMobBanner = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subTitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $shortDescription = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne]
    private ?ButtonContent $actionButton = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $validFrom = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $validTill = null;

    #[ORM\Column]
    private ?bool $isClickable = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $clickLink = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPromoBar(): ?PromoBar
    {
        return $this->promoBar;
    }

    public function setPromoBar(?PromoBar $promoBar): static
    {
        $this->promoBar = $promoBar;

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

    public function getDefaultBanner(): ?Images
    {
        return $this->defaultBanner;
    }

    public function setDefaultBanner(?Images $defaultBanner): static
    {
        $this->defaultBanner = $defaultBanner;

        return $this;
    }

    public function getDefaultMobBanner(): ?Images
    {
        return $this->defaultMobBanner;
    }

    public function setDefaultMobBanner(?Images $defaultMobBanner): static
    {
        $this->defaultMobBanner = $defaultMobBanner;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;

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

    public function getActionButton(): ?ButtonContent
    {
        return $this->actionButton;
    }

    public function setActionButton(?ButtonContent $actionButton): static
    {
        $this->actionButton = $actionButton;

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

    public function isClickable(): ?bool
    {
        return $this->isClickable;
    }

    public function setClickable(bool $isClickable): static
    {
        $this->isClickable = $isClickable;

        return $this;
    }

    public function getClickLink(): ?string
    {
        return $this->clickLink;
    }

    public function setClickLink(?string $clickLink): static
    {
        $this->clickLink = $clickLink;

        return $this;
    }
}
