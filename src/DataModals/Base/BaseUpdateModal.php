<?php

namespace App\DataModals\Base;
use Symfony\Component\Validator\Constraints as Assert;

trait BaseUpdateModal
{
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Positive]
    public int $id;
}