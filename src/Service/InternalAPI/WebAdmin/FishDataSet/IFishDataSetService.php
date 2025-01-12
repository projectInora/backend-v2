<?php

namespace App\Service\InternalAPI\WebAdmin\FishDataSet;

use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewMultiRecordModal;
use App\Entity\Authentication\AuthUser;

interface IFishDataSetService
{
    function addNewFishDataSets(AuthUser $user, NewMultiRecordModal $multiRecord) : array;
}