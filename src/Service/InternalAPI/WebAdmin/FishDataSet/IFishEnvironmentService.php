<?php

namespace App\Service\InternalAPI\WebAdmin\FishDataSet;

use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewMultiRecordModal;
use App\Entity\Authentication\AuthUser;

interface IFishEnvironmentService
{
    function addNewEnvironmentRecords(AuthUser $user, NewMultiRecordModal $multiRecordModal, string $mode) : array;
}