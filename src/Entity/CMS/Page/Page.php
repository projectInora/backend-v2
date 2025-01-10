<?php

namespace App\Entity\CMS\Page;

use App\Entity\Base\BaseStatus;
use App\Entity\CMS\Banner\BannerGroup;
use App\Entity\CMS\Promo\PromoBar;
use App\Repository\CMS\Page\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ORM\Table(name: "cms_page")]
class Page extends BaseStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $code = null;

    /**
     * @var Collection<int, PromoBar>
     */
    #[ORM\OneToMany(targetEntity: PromoBar::class, mappedBy: 'page')]
    private Collection $promoBars;

    /**
     * @var Collection<int, BannerGroup>
     */
    #[ORM\OneToMany(targetEntity: BannerGroup::class, mappedBy: 'page')]
    private Collection $bannerGroups;

    public function __construct()
    {
        parent::__construct();
        $this->promoBars = new ArrayCollection();
        $this->bannerGroups = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, PromoBar>
     */
    public function getPromoBars(): Collection
    {
        return $this->promoBars;
    }

    public function addPromoBar(PromoBar $promoBar): static
    {
        if (!$this->promoBars->contains($promoBar)) {
            $this->promoBars->add($promoBar);
            $promoBar->setPage($this);
        }

        return $this;
    }

    public function removePromoBar(PromoBar $promoBar): static
    {
        if ($this->promoBars->removeElement($promoBar)) {
            // set the owning side to null (unless already changed)
            if ($promoBar->getPage() === $this) {
                $promoBar->setPage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BannerGroup>
     */
    public function getBannerGroups(): Collection
    {
        return $this->bannerGroups;
    }

    public function addBannerGroup(BannerGroup $bannerGroup): static
    {
        if (!$this->bannerGroups->contains($bannerGroup)) {
            $this->bannerGroups->add($bannerGroup);
            $bannerGroup->setPage($this);
        }

        return $this;
    }

    public function removeBannerGroup(BannerGroup $bannerGroup): static
    {
        if ($this->bannerGroups->removeElement($bannerGroup)) {
            // set the owning side to null (unless already changed)
            if ($bannerGroup->getPage() === $this) {
                $bannerGroup->setPage(null);
            }
        }

        return $this;
    }
}
