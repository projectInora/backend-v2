<?php

namespace App\Entity\FishDataSet\Classification;

use App\Entity\Base\BaseStatus;
use App\Repository\FishDataSet\Classification\FishClassificationFamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FishClassificationFamilyRepository::class)]
class FishClassificationFamily extends BaseStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?FishClassificationOrder $cOrder = null;

    /**
     * @var Collection<int, FishClassificationGenus>
     */
    #[ORM\OneToMany(targetEntity: FishClassificationGenus::class, mappedBy: 'family')]
    private Collection $fishClassificationGenera;

    public function __construct()
    {
        parent::__construct();
        $this->fishClassificationGenera = new ArrayCollection();
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

    public function getCOrder(): ?FishClassificationOrder
    {
        return $this->cOrder;
    }

    public function setCOrder(?FishClassificationOrder $cOrder): static
    {
        $this->cOrder = $cOrder;

        return $this;
    }

    /**
     * @return Collection<int, FishClassificationGenus>
     */
    public function getFishClassificationGenera(): Collection
    {
        return $this->fishClassificationGenera;
    }

    public function addFishClassificationGenus(FishClassificationGenus $fishClassificationGenus): static
    {
        if (!$this->fishClassificationGenera->contains($fishClassificationGenus)) {
            $this->fishClassificationGenera->add($fishClassificationGenus);
            $fishClassificationGenus->setFamily($this);
        }

        return $this;
    }

    public function removeFishClassificationGenus(FishClassificationGenus $fishClassificationGenus): static
    {
        if ($this->fishClassificationGenera->removeElement($fishClassificationGenus)) {
            // set the owning side to null (unless already changed)
            if ($fishClassificationGenus->getFamily() === $this) {
                $fishClassificationGenus->setFamily(null);
            }
        }

        return $this;
    }
}
