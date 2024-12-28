<?php

namespace App\Entity\FishDataSet\Classification;

use App\Entity\Base\BaseStatus;
use App\Repository\FishDataSet\Classification\FishClassificationPhylumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FishClassificationPhylumRepository::class)]
class FishClassificationPhylum extends BaseStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\ManyToOne(inversedBy: 'fishClassificationPhylums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FishClassificationKingdom $kingdom = null;

    /**
     * @var Collection<int, FishClassificationClass>
     */
    #[ORM\OneToMany(targetEntity: FishClassificationClass::class, mappedBy: 'phylum')]
    private Collection $fishClassificationClasses;

    public function __construct()
    {
        parent::__construct();
        $this->fishClassificationClasses = new ArrayCollection();
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

    public function getKingdom(): ?FishClassificationKingdom
    {
        return $this->kingdom;
    }

    public function setKingdom(?FishClassificationKingdom $kingdom): static
    {
        $this->kingdom = $kingdom;

        return $this;
    }

    /**
     * @return Collection<int, FishClassificationClass>
     */
    public function getFishClassificationClasses(): Collection
    {
        return $this->fishClassificationClasses;
    }

    public function addFishClassificationClass(FishClassificationClass $fishClassificationClass): static
    {
        if (!$this->fishClassificationClasses->contains($fishClassificationClass)) {
            $this->fishClassificationClasses->add($fishClassificationClass);
            $fishClassificationClass->setPhylum($this);
        }

        return $this;
    }

    public function removeFishClassificationClass(FishClassificationClass $fishClassificationClass): static
    {
        if ($this->fishClassificationClasses->removeElement($fishClassificationClass)) {
            // set the owning side to null (unless already changed)
            if ($fishClassificationClass->getPhylum() === $this) {
                $fishClassificationClass->setPhylum(null);
            }
        }

        return $this;
    }
}
