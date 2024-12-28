<?php

namespace App\Entity\FishDataSet\Classification;

use App\Entity\Base\BaseStatus;
use App\Repository\FishDataSet\Classification\FishClassificationOrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FishClassificationOrderRepository::class)]
class FishClassificationOrder extends BaseStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $code = null;

    #[ORM\ManyToOne(inversedBy: 'fishClassificationOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FishClassificationClass $cClass = null;

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

    public function getCClass(): ?FishClassificationClass
    {
        return $this->cClass;
    }

    public function setCClass(?FishClassificationClass $cClass): static
    {
        $this->cClass = $cClass;

        return $this;
    }
}
