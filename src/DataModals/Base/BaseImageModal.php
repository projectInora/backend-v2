<?php

namespace App\DataModals\Base;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BaseImageModal
{
    #[Assert\NotNull]
    public UploadedFile $imageFile;

    public ?UploadedFile $mobileImageFile;

    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    public string $displayOrder;

    public ?string $aspDivWidth;
    public ?string $aspDivHeight;
}