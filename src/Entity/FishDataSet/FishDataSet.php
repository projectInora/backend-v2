<?php

namespace App\Entity\FishDataSet;

use App\Entity\Base\BaseFullRecord;
use App\Entity\FishDataSet\Classification\FishClassificationSpecies;
use App\Entity\FishDataSet\Environment\FishEnvironmentClimateZone;
use App\Entity\FishDataSet\Environment\FishEnvironmentDepthRange;
use App\Entity\FishDataSet\Environment\FishEnvironmentDistributionRange;
use App\Entity\FishDataSet\Environment\FishEnvironmentMilieu;
use App\Repository\FishDataSet\FishDataSetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FishDataSetRepository::class)]
class FishDataSet extends BaseFullRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameTa = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameSn = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameInSrilanka = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $scientificName = null;

    #[ORM\Column(nullable: true)]
    private ?array $commonNames = null;

    #[ORM\ManyToOne]
    private ?FishClassificationSpecies $classificationSpices = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $biology = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lifeCycle = null;

    #[ORM\ManyToOne]
    private ?FishEnvironmentMilieu $envMilieu = null;

    #[ORM\ManyToOne]
    private ?FishEnvironmentClimateZone $envClimateZone = null;

    #[ORM\ManyToOne]
    private ?FishEnvironmentDepthRange $envDepthRange = null;

    #[ORM\ManyToOne]
    private ?FishEnvironmentDistributionRange $envDistributionRange = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $distribution = null;

    #[ORM\Column(nullable: true)]
    private ?array $sizes = null;

    #[ORM\Column(nullable: true)]
    private ?array $weights = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $age = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $shortDescription = null;

    #[ORM\Column(nullable: true)]
    private ?array $commercialUses = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $threatToHuman = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $redListStatus = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $weather = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $salinity = null;

    #[ORM\Column(nullable: true)]
    private ?array $humanUses = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    public function __construct()
    {
        parent::__construct();
        $this->uuid = strtoupper(uniqid("FDS_"));
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

    public function getNameTa(): ?string
    {
        return $this->nameTa;
    }

    public function setNameTa(?string $nameTa): static
    {
        $this->nameTa = $nameTa;

        return $this;
    }

    public function getNameSn(): ?string
    {
        return $this->nameSn;
    }

    public function setNameSn(?string $nameSn): static
    {
        $this->nameSn = $nameSn;

        return $this;
    }

    public function getNameInSrilanka(): ?string
    {
        return $this->nameInSrilanka;
    }

    public function setNameInSrilanka(?string $nameInSrilanka): static
    {
        $this->nameInSrilanka = $nameInSrilanka;

        return $this;
    }

    public function getScientificName(): ?string
    {
        return $this->scientificName;
    }

    public function setScientificName(?string $scientificName): static
    {
        $this->scientificName = $scientificName;

        return $this;
    }

    public function getCommonNames(): ?array
    {
        return $this->commonNames;
    }

    public function setCommonNames(?array $commonNames): static
    {
        $this->commonNames = $commonNames;

        return $this;
    }

    public function getClassificationSpices(): ?FishClassificationSpecies
    {
        return $this->classificationSpices;
    }

    public function setClassificationSpices(?FishClassificationSpecies $classificationSpices): static
    {
        $this->classificationSpices = $classificationSpices;

        return $this;
    }

    public function getBiology(): ?string
    {
        return $this->biology;
    }

    public function setBiology(?string $biology): static
    {
        $this->biology = $biology;

        return $this;
    }

    public function getLifeCycle(): ?string
    {
        return $this->lifeCycle;
    }

    public function setLifeCycle(?string $lifeCycle): static
    {
        $this->lifeCycle = $lifeCycle;

        return $this;
    }

    public function getEnvMilieu(): ?FishEnvironmentMilieu
    {
        return $this->envMilieu;
    }

    public function setEnvMilieu(?FishEnvironmentMilieu $envMilieu): static
    {
        $this->envMilieu = $envMilieu;

        return $this;
    }

    public function getEnvClimateZone(): ?FishEnvironmentClimateZone
    {
        return $this->envClimateZone;
    }

    public function setEnvClimateZone(?FishEnvironmentClimateZone $envClimateZone): static
    {
        $this->envClimateZone = $envClimateZone;

        return $this;
    }

    public function getEnvDepthRange(): ?FishEnvironmentDepthRange
    {
        return $this->envDepthRange;
    }

    public function setEnvDepthRange(?FishEnvironmentDepthRange $envDepthRange): static
    {
        $this->envDepthRange = $envDepthRange;

        return $this;
    }

    public function getEnvDistributionRange(): ?FishEnvironmentDistributionRange
    {
        return $this->envDistributionRange;
    }

    public function setEnvDistributionRange(?FishEnvironmentDistributionRange $envDistributionRange): static
    {
        $this->envDistributionRange = $envDistributionRange;

        return $this;
    }

    public function getDistribution(): ?string
    {
        return $this->distribution;
    }

    public function setDistribution(?string $distribution): static
    {
        $this->distribution = $distribution;

        return $this;
    }

    public function getSizes(): ?array
    {
        return $this->sizes;
    }

    public function setSizes(?array $sizes): static
    {
        $this->sizes = $sizes;

        return $this;
    }

    public function getWeights(): ?array
    {
        return $this->weights;
    }

    public function setWeights(?array $weights): static
    {
        $this->weights = $weights;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(?string $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getCommercialUses(): ?array
    {
        return $this->commercialUses;
    }

    public function setCommercialUses(?array $commercialUses): static
    {
        $this->commercialUses = $commercialUses;

        return $this;
    }

    public function getThreatToHuman(): ?string
    {
        return $this->threatToHuman;
    }

    public function setThreatToHuman(?string $threatToHuman): static
    {
        $this->threatToHuman = $threatToHuman;

        return $this;
    }

    public function getRedListStatus(): ?string
    {
        return $this->redListStatus;
    }

    public function setRedListStatus(?string $redListStatus): static
    {
        $this->redListStatus = $redListStatus;

        return $this;
    }

    public function getWeather(): ?string
    {
        return $this->weather;
    }

    public function setWeather(?string $weather): static
    {
        $this->weather = $weather;

        return $this;
    }

    public function getSalinity(): ?string
    {
        return $this->salinity;
    }

    public function setSalinity(?string $salinity): static
    {
        $this->salinity = $salinity;

        return $this;
    }

    public function getHumanUses(): ?array
    {
        return $this->humanUses;
    }

    public function setHumanUses(?array $humanUses): static
    {
        $this->humanUses = $humanUses;

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
}
