<?php

namespace App\Entity\CMS\Promo;

use App\Entity\Base\BaseFullRecord;
use App\Entity\Meta\Image;
use App\Repository\CMS\Promo\PromoBarContentImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromoBarContentImageRepository::class)]
#[ORM\Table(name: "cms_promo_bar_content_image")]
class PromoBarContentImage extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PromoBarContent $promoContent = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Image $image = null;

    #[ORM\ManyToOne]
    private ?Image $mobileImage = null;

    #[ORM\Column]
    private ?int $displayOrder = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $validFrom = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $validTill = null;

    #[ORM\Column]
    private ?float $aspDivWidth = null;

    #[ORM\Column]
    private ?float $aspDivHeight = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPromoContent(): ?PromoBarContent
    {
        return $this->promoContent;
    }

    public function setPromoContent(?PromoBarContent $promoContent): static
    {
        $this->promoContent = $promoContent;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getMobileImage(): ?Image
    {
        return $this->mobileImage;
    }

    public function setMobileImage(?Image $mobileImage): static
    {
        $this->mobileImage = $mobileImage;

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

    public function getAspDivWidth(): ?float
    {
        return $this->aspDivWidth;
    }

    public function setAspDivWidth(float $aspDivWidth): static
    {
        $this->aspDivWidth = $aspDivWidth;

        return $this;
    }

    public function getAspDivHeight(): ?float
    {
        return $this->aspDivHeight;
    }

    public function setAspDivHeight(float $aspDivHeight): static
    {
        $this->aspDivHeight = $aspDivHeight;

        return $this;
    }
}
