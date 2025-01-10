<?php

namespace App\Repository\Authentication;

use App\Entity\Authentication\AuthUserTokenAccess;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AuthUserTokenAccess>
 */
class AuthUserTokenAccessRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthUserTokenAccess::class);
    }

    public function persistNewAccessToken(AuthUserTokenAccess $accessToken): void
    {
        dd($accessToken);
        // Add custom data to the access token before saving
        $accessToken->setCustomField('my_custom_value');

        // Call the parent method to handle persistence
        parent::persistNewAccessToken($accessToken);
    }

//    /**
//     * @return AuthUserTokenAccess[] Returns an array of AuthUserTokenAccess objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AuthUserTokenAccess
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
