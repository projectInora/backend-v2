<?php

namespace App\Service\Security\OAuth2;

interface IUserTokenAccessService
{
    function addNewUserAccessTokenRecord(string $tokenIdentifier, ?string $userIdentifier = null);
}