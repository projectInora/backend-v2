<?php

namespace App\Service\Security\OAuth2;

use App\Entity\Authentication\AuthUser;
use App\Entity\Authentication\AuthUserTokenAccess;
use App\Service\Base\BaseService;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\NoReturn;

class UserTokenAccessService extends BaseService implements IUserTokenAccessService
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    function addNewUserAccessTokenRecord(string $tokenIdentifier, ?string $userIdentifier = null): void
    {
        $tokenAccess = new AuthUserTokenAccess();
        $tokenAccess->setToken($tokenIdentifier);
        $user = $this->em->getRepository(AuthUser::class)->findOneBy(array('username' => $userIdentifier));
        if($user != null){
            $tokenAccess->setAuthUser($user);
        }
        $this->em->persist($tokenAccess);
        $this->em->flush();

        //todo client log
    }
}