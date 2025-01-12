<?php

namespace App\DataModals\Base;
use Symfony\Component\Validator\Constraints as Assert;

trait BaseMetaModal
{
    #[Assert\NotBlank]
    #[Assert\NotNull]
    public string $name;

    public ?string $code;
}