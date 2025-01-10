<?php

namespace App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\CMS\HomePage;
use App\DataModals\Base\ExpireImageModal;
use Symfony\Component\Validator\Constraints as Assert;

class NewBannerContentModal extends ExpireImageModal
{
    public ?int $id;
    public ?bool $isDeleted;

    public ?string $alt;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    public string $isClickable;

    public ?string $clickLink;
}