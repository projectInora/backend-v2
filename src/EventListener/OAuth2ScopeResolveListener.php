<?php

namespace App\EventListener;

use League\Bundle\OAuth2ServerBundle\Event\ScopeResolveEvent;

final class OAuth2ScopeResolveListener
{
    public function onScopeResolve(ScopeResolveEvent $event): void
    {
        $requestedScopes = $event->getScopes();

        // ...Make adjustments to the client's requested scopes...

        $event->setScopes(...$requestedScopes);
    }
}