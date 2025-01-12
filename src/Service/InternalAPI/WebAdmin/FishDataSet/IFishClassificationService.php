<?php

namespace App\Service\InternalAPI\WebAdmin\FishDataSet;

use App\DataModals\InternalAPI\V1\RequestModal\WebAdmin\FishDataSet\NewMultiRecordModal;
use App\Entity\Authentication\AuthUser;

interface IFishClassificationService
{
    function addNewKingdoms(AuthUser $user, NewMultiRecordModal $multiRecordModal) : array;
    function addNewMultiPhylum(AuthUser $user, NewMultiRecordModal $multiRecordModal) : array;
    function addNewPhylumClasses(AuthUser $user, NewMultiRecordModal $multiRecordModal) : array;
    function addNewClassOrders(AuthUser $user, NewMultiRecordModal $multiRecordModal) : array;
    function addNewFamilies(AuthUser $user, NewMultiRecordModal $multiRecordModal) : array;
    function addNewMultiGenus(AuthUser $user, NewMultiRecordModal $multiRecordModal) : array;
    function addNewMultiSpecies(AuthUser $user, NewMultiRecordModal $multiRecordModal) : array;
}