<?php

namespace App\Entity\Image;

use App\Entity\Base\BaseFullRecord;
use App\Entity\Product\ProductCategoryImages;
use App\Repository\Image\ImagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 20)]
    private ?string $extension = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $localPath = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cdnPath = null;

    #[ORM\Column(length: 255)]
    private ?string $fullImageName = null;

    #[ORM\Column(nullable: true)]
    private ?float $aspDivWidth = null;

    #[ORM\Column(nullable: true)]
    private ?float $aspDivHeight = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    /**
     * @var Collection<int, ProductCategoryImages>
     */
    #[ORM\OneToMany(targetEntity: ProductCategoryImages::class, mappedBy: 'mobileImage')]
    private Collection $productCategoryImages;

    public function __construct()
    {
        parent::__construct();
        $this->uuid = strtoupper(uniqid('IMG_'));
        $this->productCategoryImages = new ArrayCollection();
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

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): static
    {
        $this->extension = $extension;

        return $this;
    }

    public function getLocalPath(): ?string
    {
        return $this->localPath;
    }

    public function setLocalPath(?string $localPath): static
    {
        $this->localPath = $localPath;

        return $this;
    }

    public function getCdnPath(): ?string
    {
        return $this->cdnPath;
    }

    public function setCdnPath(?string $cdnPath): static
    {
        $this->cdnPath = $cdnPath;

        return $this;
    }

    public function getFullImageName(): ?string
    {
        return $this->fullImageName;
    }

    public function setFullImageName(string $fullImageName): static
    {
        $this->fullImageName = $fullImageName;

        return $this;
    }

    public function getAspDivWidth(): ?float
    {
        return $this->aspDivWidth;
    }

    public function setAspDivWidth(?float $aspDivWidth): static
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

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return Collection<int, ProductCategoryImages>
     */
    public function getProductCategoryImages(): Collection
    {
        return $this->productCategoryImages;
    }

    public function addProductCategoryImage(ProductCategoryImages $productCategoryImage): static
    {
        if (!$this->productCategoryImages->contains($productCategoryImage)) {
            $this->productCategoryImages->add($productCategoryImage);
            $productCategoryImage->setMobileImage($this);
        }

        return $this;
    }

    public function removeProductCategoryImage(ProductCategoryImages $productCategoryImage): static
    {
        if ($this->productCategoryImages->removeElement($productCategoryImage)) {
            // set the owning side to null (unless already changed)
            if ($productCategoryImage->getMobileImage() === $this) {
                $productCategoryImage->setMobileImage(null);
            }
        }

        return $this;
    }
}
