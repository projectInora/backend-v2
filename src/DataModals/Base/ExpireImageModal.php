<?php

namespace App\DataModals\Base;

use App\DataModals\Base\BaseImageModal;
use Symfony\Component\Validator\Constraints as Assert;

class ExpireImageModal extends BaseImageModal
{
    #[Assert\NotBlank]
    #[Assert\DateTime(format: 'Y-m-d H:i:s')]
    public ?string $validFrom = null;

    #[Assert\NotBlank]
    #[Assert\DateTime(format: 'Y-m-d H:i:s')]
    public ?string $validTill = null;

    
}