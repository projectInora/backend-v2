<?php

namespace App\Service\InternalAPI\CMS\Banner;

use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\CMS\HomePage\NewBannerGroupModal;
use App\Entity\Authentication\AuthUser;

interface IBannerGroupService
{
    function addNewBannerGroup(AuthUser $user, NewBannerGroupModal $bannerGroupModal) : array;
    function getHomePageMainBannerGroup(): array;
}