<?php

namespace App\Entity\CMS\Banner;

use App\Entity\Base\BaseFullRecord;
use App\Entity\Image\Images;
use App\Repository\CMS\Banner\BannerContentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BannerContentRepository::class)]
#[ORM\Table(name: "cms_banner_content")]
class BannerContent extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Images $webImage = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?Images $mobileImage = null;

    #[ORM\Column(length: 100)]
    private ?string $alt = null;

    #[ORM\Column]
    private ?bool $isClickable = null;

    #[ORM\Column(length: 255)]
    private ?string $clickLink = null;

    #[ORM\Column]
    private ?int $displayOrder = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $validFrom = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $validTill = null;

    #[ORM\ManyToOne(inversedBy: 'bannerContents')]
    private ?BannerGroup $bannerGroup = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWebImage(): ?Images
    {
        return $this->webImage;
    }

    public function setWebImage(Images $webImage): static
    {
        $this->webImage = $webImage;

        return $this;
    }

    public function getMobileImage(): ?Images
    {
        return $this->mobileImage;
    }

    public function setMobileImage(?Image $mobileImage): static
    {
        $this->mobileImage = $mobileImage;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): static
    {
        $this->alt = $alt;

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

    public function setClickLink(string $clickLink): static
    {
        $this->clickLink = $clickLink;

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

    public function getBannerGroup(): ?BannerGroup
    {
        return $this->bannerGroup;
    }

    public function setBannerGroup(?BannerGroup $bannerGroup): static
    {
        $this->bannerGroup = $bannerGroup;

        return $this;
    }
}
