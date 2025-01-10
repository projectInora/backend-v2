<?php

namespace App\Repository\CMS\Promo;

use App\Entity\CMS\Promo\PromoType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PromoType>
 */
class PromoTypeRepository extends ServiceEntityRepository
{
    const TIMEZONE = 'Asia/Colombo';
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PromoType::class);
    }

    //    /**
    //     * @return PromoType[] Returns an array of PromoType objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PromoType
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
