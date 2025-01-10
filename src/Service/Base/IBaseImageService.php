<?php

namespace App\Service\Base;

use App\Entity\Image\Images;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface IBaseImageService
{
    function uploadImageLocally(UploadedFile $image, string $destination, string $fileName = null, array $asp = null, bool $isFlush = false): array|Images;
}