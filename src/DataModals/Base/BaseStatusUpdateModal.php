<?php

namespace App\DataModals\Base;
use Symfony\Component\Validator\Constraints as Assert;

trait BaseStatusUpdateModal
{
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Positive]
    public int $id;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    public bool $status;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    public bool $isActive;
}