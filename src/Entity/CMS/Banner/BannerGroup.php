<?php

namespace App\Entity\CMS\Banner;

use App\Entity\Base\BaseFullRecord;
use App\Entity\CMS\Base\ButtonContent;
use App\Entity\CMS\Page\Page;
use App\Repository\CMS\Banner\BannerGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BannerGroupRepository::class)]
#[ORM\Table(name: "cms_banner_group")]
class BannerGroup extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $mainTitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subTitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $shortDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isActionButtonEnabled = null;

    #[ORM\Column]
    private ?int $groupOrder = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?BannerGroupType $groupType = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $validFrom = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $validTill = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?ButtonContent $actionButton = null;

    /**
     * @var Collection<int, BannerContent>
     */
    #[ORM\OneToMany(targetEntity: BannerContent::class, mappedBy: 'bannerGroup')]
    private Collection $bannerContents;

    #[ORM\ManyToOne(inversedBy: 'bannerGroups')]
    private ?Page $page = null;


    public function __construct()
    {
        parent::__construct();
        $this->bannerContents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainTitle(): ?string
    {
        return $this->mainTitle;
    }

    public function setMainTitle(string $mainTitle): static
    {
        $this->mainTitle = $mainTitle;

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

    public function isActionButtonEnabled(): ?bool
    {
        return $this->isActionButtonEnabled;
    }

    public function setActionButtonEnabled(bool $isActionButtonEnabled): static
    {
        $this->isActionButtonEnabled = $isActionButtonEnabled;

        return $this;
    }

    public function getGroupOrder(): ?int
    {
        return $this->groupOrder;
    }

    public function setGroupOrder(int $groupOrder): static
    {
        $this->groupOrder = $groupOrder;

        return $this;
    }

    public function getGroupType(): ?BannerGroupType
    {
        return $this->groupType;
    }

    public function setGroupType(?BannerGroupType $groupType): static
    {
        $this->groupType = $groupType;

        return $this;
    }

    public function getValidFrom(): ?\DateTimeImmutable
    {
        return $this->validFrom;
    }

    public function setValidFrom(\DateTimeImmutable $validFrom): static
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

    public function getActionButton(): ?ButtonContent
    {
        return $this->actionButton;
    }

    public function setActionButton(?ButtonContent $actionButton): static
    {
        $this->actionButton = $actionButton;

        return $this;
    }

    /**
     * @return Collection<int, BannerContent>
     */
    public function getBannerContents(): Collection
    {
        return $this->bannerContents;
    }

    public function addBannerContent(BannerContent $bannerContent): static
    {
        if (!$this->bannerContents->contains($bannerContent)) {
            $this->bannerContents->add($bannerContent);
            $bannerContent->setBannerGroup($this);
        }

        return $this;
    }

    public function removeBannerContent(BannerContent $bannerContent): static
    {
        if ($this->bannerContents->removeElement($bannerContent)) {
            // set the owning side to null (unless already changed)
            if ($bannerContent->getBannerGroup() === $this) {
                $bannerContent->setBannerGroup(null);
            }
        }

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
