<?php

namespace App\Service\InternalAPI\CMS\Page;

use App\Entity\Authentication\AuthUser;
use App\Service\InternalAPI\WebAdmin\CMS\Page\NewPopularTourCategoryModel;

interface IPageService
{
    function getHomePageSearchTabs() : array;

    function getHomePageTourCategories() : array;

    function getHomePagePopularDestinations() : array;

    function getHomePagePlatformUserReviews() : array;

    function NewPopularTourCategoryModel(AuthUser $user, NewPopularTourCategoryModel $NewPopularTourCategoryModel) : array;
}