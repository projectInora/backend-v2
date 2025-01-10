<?php

namespace App\EventListener;

use App\Entity\Authentication\AuthUser;
use League\Bundle\OAuth2ServerBundle\Event\UserResolveEvent;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class OAuth2UserResolveListener
{
    /**
     * @var UserProviderInterface
     */
    private UserProviderInterface $userProvider;

    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserProviderInterface $userProvider, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userProvider = $userProvider;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function onUserResolve(UserResolveEvent $event): void
    {
        try {
            $user = $this->userProvider->loadUserByIdentifier($event->getUsername());
            if($user instanceof UserInterface && !$user->isIsActive()) {
                return;
            }
        } catch (AuthenticationException $e) {
            return;
        }

        if (!($user instanceof PasswordAuthenticatedUserInterface)) {
            return;
        }

        if (!$this->userPasswordHasher->isPasswordValid($user, $event->getPassword())) {
            return;
        }

        $event->setUser($user);
    }
}