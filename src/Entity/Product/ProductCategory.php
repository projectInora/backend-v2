<?php

namespace App\Entity\Product;

use App\Entity\Base\BaseStatus;
use App\Entity\Meta\CategoryStatus;
use App\Repository\Product\ProductCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductCategoryRepository::class)]
class ProductCategory extends BaseStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $code = null;

    #[ORM\ManyToOne]
    private ?CategoryStatus $categoryStatus = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isVisible = null;

    #[ORM\Column]
    private ?bool $isFilterable = null;

    #[ORM\Column]
    private ?bool $isSubCategory = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    private ?self $parentCategory = null;

    #[ORM\Column]
    private ?int $subCategoryLevel = null;
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getCategoryStatus(): ?CategoryStatus
    {
        return $this->categoryStatus;
    }

    public function setCategoryStatus(?CategoryStatus $categoryStatus): static
    {
        $this->categoryStatus = $categoryStatus;

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

    public function isVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setVisible(bool $isVisible): static
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    public function isFilterable(): ?bool
    {
        return $this->isFilterable;
    }

    public function setFilterable(bool $isFilterable): static
    {
        $this->isFilterable = $isFilterable;

        return $this;
    }

    public function isSubCategory(): ?bool
    {
        return $this->isSubCategory;
    }

    public function setSubCategory(bool $isSubCategory): static
    {
        $this->isSubCategory = $isSubCategory;

        return $this;
    }

    public function getParentCategory(): ?self
    {
        return $this->parentCategory;
    }

    public function setParentCategory(?self $parentCategory): static
    {
        $this->parentCategory = $parentCategory;

        return $this;
    }

    public function getSubCategoryLevel(): ?int
    {
        return $this->subCategoryLevel;
    }

    public function setSubCategoryLevel(int $subCategoryLevel): static
    {
        $this->subCategoryLevel = $subCategoryLevel;

        return $this;
    }
}
