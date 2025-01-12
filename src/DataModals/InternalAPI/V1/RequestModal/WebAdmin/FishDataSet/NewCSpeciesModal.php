<?php

namespace App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet;
use App\DataModals\Base\BaseMetaModal;
use Symfony\Component\Validator\Constraints as Assert;
class NewCSpeciesModal
{
    use BaseMetaModal;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    public string $genusCode;
}