<?php

namespace App\DataModals\Base;
use Symfony\Component\Validator\Constraints as Assert;

trait BaseDeleteModal
{
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Positive]
    public int $id;

    public ?string $remark;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    public bool $isDeleted;
}