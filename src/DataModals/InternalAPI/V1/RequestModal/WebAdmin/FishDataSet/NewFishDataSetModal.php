<?php

namespace App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet;
use Symfony\Component\Validator\Constraints as Assert;

class NewFishDataSetModal
{
    #[Assert\NotBlank]
    #[Assert\NotNull]
    public string $name;

    public ?string $nameTa;
    public ?string $nameSn;
    public ?string $nameInSrilanka;
    public ?string $scientificName;
    public ?array $commonNames; //<string>

    #[Assert\NotBlank]
    #[Assert\NotNull]
    public int $classificationSpecies;

    public ?string $biology;
    public ?string $lifeCycle;
    public ?int $envMilieu;
    public ?int $envClimateZone;
    public ?int $envDepthRange;
    public ?int $envDistributionRange;
    public ?string $distribution;
    public ?array $sizes;
    public ?array $weights;
    public ?string $age;
    public ?string $shortDescription;
    public ?array $commercialUses;
    public ?string $threatToHuman;
    public ?string $redListStatus;
    public ?string $weather;
    public ?string $salinity;
    public ?array $humanUses;
}