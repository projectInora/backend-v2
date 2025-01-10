<?php

namespace App\DataModals\Base;

use Symfony\Component\Validator\Constraints as Assert;

class ActionButtonModal
{

    #[Assert\NotNull]
    #[Assert\NotBlank]
    public string $text;

    public ?string $hrefLink;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    public string $isNewTab;

    public ?string $validFrom = null;

    public ?string $validTill = null;
}