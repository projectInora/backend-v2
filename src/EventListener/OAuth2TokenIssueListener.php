<?php

namespace App\EventListener;

use App\Service\Security\OAuth2\IUserTokenAccessService;
use Doctrine\ORM\EntityManagerInterface;
use League\Bundle\OAuth2ServerBundle\Entity\Scope;
use League\OAuth2\Server\RequestAccessTokenEvent;

final class OAuth2TokenIssueListener
{

    private IUserTokenAccessService $userTokenAccessService;

    /**
     * @param IUserTokenAccessService $userTokenAccessService
     */
    public function __construct(IUserTokenAccessService $userTokenAccessService)
    {
        $this->userTokenAccessService = $userTokenAccessService;
    }

    public function onAccessTokenIssuedEvent(RequestAccessTokenEvent $event): void
    {
        $this->userTokenAccessService->addNewUserAccessTokenRecord($event->getAccessToken()->getIdentifier(), $event->getAccessToken()->getUserIdentifier());
    }
}