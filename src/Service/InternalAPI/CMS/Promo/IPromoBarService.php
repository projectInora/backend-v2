<?php

namespace App\Service\InternalAPI\CMS\Promo;

use App\Entity\Authentication\AuthUser;
use App\Service\InternalAPI\WebAdmin\CMS\Promo\NewPromoBarModal;

interface IPromoBarService
{
    function getHomePageProBarGroups(): array;

    function addNewPromoBar(AuthUser $user, NewPromoBarModal $promoBarModal) : array;
}