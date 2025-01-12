<?php

namespace App\Entity\FishDataSet\Classification;

use App\Entity\Base\BaseRecord;
use App\Entity\Base\BaseStatus;
use App\Repository\FishDataSet\Classification\FishClassificationClassRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FishClassificationClassRepository::class)]
class FishClassificationClass extends BaseRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $code = null;

    #[ORM\ManyToOne(inversedBy: 'fishClassificationClasses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FishClassificationPhylum $phylum = null;

    /**
     * @var Collection<int, FishClassificationOrder>
     */
    #[ORM\OneToMany(targetEntity: FishClassificationOrder::class, mappedBy: 'cClass')]
    private Collection $fishClassificationOrders;

    public function __construct()
    {
        parent::__construct();
        $this->fishClassificationOrders = new ArrayCollection();
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

    public function getPhylum(): ?FishClassificationPhylum
    {
        return $this->phylum;
    }

    public function setPhylum(?FishClassificationPhylum $phylum): static
    {
        $this->phylum = $phylum;

        return $this;
    }

    /**
     * @return Collection<int, FishClassificationOrder>
     */
    public function getFishClassificationOrders(): Collection
    {
        return $this->fishClassificationOrders;
    }

    public function addFishClassificationOrder(FishClassificationOrder $fishClassificationOrder): static
    {
        if (!$this->fishClassificationOrders->contains($fishClassificationOrder)) {
            $this->fishClassificationOrders->add($fishClassificationOrder);
            $fishClassificationOrder->setCClass($this);
        }

        return $this;
    }

    public function removeFishClassificationOrder(FishClassificationOrder $fishClassificationOrder): static
    {
        if ($this->fishClassificationOrders->removeElement($fishClassificationOrder)) {
            // set the owning side to null (unless already changed)
            if ($fishClassificationOrder->getCClass() === $this) {
                $fishClassificationOrder->setCClass(null);
            }
        }

        return $this;
    }
}
