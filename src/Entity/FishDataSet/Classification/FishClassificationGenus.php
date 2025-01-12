<?php

namespace App\Entity\FishDataSet\Classification;

use App\Entity\Base\BaseRecord;
use App\Entity\Base\BaseStatus;
use App\Repository\FishDataSet\Classification\FishClassificationGenusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FishClassificationGenusRepository::class)]
class FishClassificationGenus extends BaseRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\ManyToOne(inversedBy: 'fishClassificationGenera')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FishClassificationFamily $family = null;

    /**
     * @var Collection<int, FishClassificationSpecies>
     */
    #[ORM\OneToMany(targetEntity: FishClassificationSpecies::class, mappedBy: 'genus')]
    private Collection $fishClassificationSpecies;

    public function __construct()
    {
        parent::__construct();
        $this->fishClassificationSpecies = new ArrayCollection();
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

    public function getFamily(): ?FishClassificationFamily
    {
        return $this->family;
    }

    public function setFamily(?FishClassificationFamily $family): static
    {
        $this->family = $family;

        return $this;
    }

    /**
     * @return Collection<int, FishClassificationSpecies>
     */
    public function getFishClassificationSpecies(): Collection
    {
        return $this->fishClassificationSpecies;
    }

    public function addFishClassificationSpecies(FishClassificationSpecies $fishClassificationSpecies): static
    {
        if (!$this->fishClassificationSpecies->contains($fishClassificationSpecies)) {
            $this->fishClassificationSpecies->add($fishClassificationSpecies);
            $fishClassificationSpecies->setGenus($this);
        }

        return $this;
    }

    public function removeFishClassificationSpecies(FishClassificationSpecies $fishClassificationSpecies): static
    {
        if ($this->fishClassificationSpecies->removeElement($fishClassificationSpecies)) {
            // set the owning side to null (unless already changed)
            if ($fishClassificationSpecies->getGenus() === $this) {
                $fishClassificationSpecies->setGenus(null);
            }
        }

        return $this;
    }
}
