<?php

namespace App\Entity\FishDataSet\Classification;

use App\Entity\Base\BaseStatus;
use App\Repository\FishDataSet\Classification\FishClassificationKingdomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FishClassificationKingdomRepository::class)]
class FishClassificationKingdom extends BaseStatus
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
     * @var Collection<int, FishClassificationPhylum>
     */
    #[ORM\OneToMany(targetEntity: FishClassificationPhylum::class, mappedBy: 'kingdom')]
    private Collection $fishClassificationPhylums;

    public function __construct()
    {
        parent::__construct();
        $this->fishClassificationPhylums = new ArrayCollection();
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
     * @return Collection<int, FishClassificationPhylum>
     */
    public function getFishClassificationPhylums(): Collection
    {
        return $this->fishClassificationPhylums;
    }

    public function addFishClassificationPhylum(FishClassificationPhylum $fishClassificationPhylum): static
    {
        if (!$this->fishClassificationPhylums->contains($fishClassificationPhylum)) {
            $this->fishClassificationPhylums->add($fishClassificationPhylum);
            $fishClassificationPhylum->setKingdom($this);
        }

        return $this;
    }

    public function removeFishClassificationPhylum(FishClassificationPhylum $fishClassificationPhylum): static
    {
        if ($this->fishClassificationPhylums->removeElement($fishClassificationPhylum)) {
            // set the owning side to null (unless already changed)
            if ($fishClassificationPhylum->getKingdom() === $this) {
                $fishClassificationPhylum->setKingdom(null);
            }
        }

        return $this;
    }
}
