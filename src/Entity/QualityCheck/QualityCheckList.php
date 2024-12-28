<?php

namespace App\Entity\QualityCheck;

use App\Entity\Base\BaseStatus;
use App\Entity\Meta\CheckListType;
use App\Repository\QualityCheck\QualityCheckListRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QualityCheckListRepository::class)]
class QualityCheckList extends BaseStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CheckListType $checkListType = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    #[ORM\Column]
    private ?bool $isRequired = null;

    #[ORM\Column]
    private ?float $minMarks = null;

    #[ORM\Column]
    private ?float $maxMarks = null;

    #[ORM\Column]
    private ?float $passMarks = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCheckListType(): ?CheckListType
    {
        return $this->checkListType;
    }

    public function setCheckListType(?CheckListType $checkListType): static
    {
        $this->checkListType = $checkListType;

        return $this;
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

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function isRequired(): ?bool
    {
        return $this->isRequired;
    }

    public function setRequired(bool $isRequired): static
    {
        $this->isRequired = $isRequired;

        return $this;
    }

    public function getMinMarks(): ?float
    {
        return $this->minMarks;
    }

    public function setMinMarks(float $minMarks): static
    {
        $this->minMarks = $minMarks;

        return $this;
    }

    public function getMaxMarks(): ?float
    {
        return $this->maxMarks;
    }

    public function setMaxMarks(float $maxMarks): static
    {
        $this->maxMarks = $maxMarks;

        return $this;
    }

    public function getPassMarks(): ?float
    {
        return $this->passMarks;
    }

    public function setPassMarks(float $passMarks): static
    {
        $this->passMarks = $passMarks;

        return $this;
    }
}
