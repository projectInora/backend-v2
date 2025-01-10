<?php

namespace App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\CMS\HomePage;
use App\DataModals\Base\ActionButtonModal;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class NewBannerGroupModal
{
    public ?int $id;
    public ?bool $isDeleted;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    public string $mainTitle;

    public ?string $subTitle;

    public ?string $shortDescription;

    public ?string $description;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    public string $groupTypeCode;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    public string $groupOrder;

    #[Assert\NotBlank]
    #[Assert\DateTime(format: 'Y-m-d H:i:s')]
    public ?string $validFrom = null;

    public ?string $validTill;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    public string $isActionButtonEnable;

    public ?ActionButtonModal $actionButtonModal;

    /**
     * @var NewBannerContentModal[]|Collection
     * @SerializedName("bannerContents")
     * @Assert\Valid
     * @Assert\All([
     *     new Assert\Type(type: DestinationImageModal::class)
     * ])
     */
    public ?array $bannerContents; //[]<NewBannerContentModal>
}