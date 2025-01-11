<?php

namespace App\Entity\Product;

use App\Entity\Base\BaseFullRecord;
use App\Entity\Base\BaseRecord;
use App\Entity\Meta\CategoryStatus;
use App\Repository\Product\FishProductCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FishProductCategoryRepository::class)]
class FishProductCategory extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductCategory $productCategory = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?FishProduct $fishProduct = null;


    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductCategory(): ?ProductCategory
    {
        return $this->productCategory;
    }

    public function setProductCategory(?ProductCategory $productCategory): static
    {
        $this->productCategory = $productCategory;

        return $this;
    }

    public function getFishProduct(): ?FishProduct
    {
        return $this->fishProduct;
    }

    public function setFishProduct(?FishProduct $fishProduct): static
    {
        $this->fishProduct = $fishProduct;

        return $this;
    }
}
