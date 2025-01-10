<?php

namespace App\Repository\CMS\Promo;

use App\Entity\CMS\Promo\PromoBar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PromoBar>
 */
class PromoBarRepository extends ServiceEntityRepository
{
    const TIMEZONE = 'Asia/Colombo';
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PromoBar::class);
    }

    public function filterBy(array $filterPara = []): array
    {
        $isActive = $filterPara['isActive'] ?? true;
        $status = $filterPara['status'] ?? true;

        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.page', 'pg')
            ->leftJoin('p.promoType', 'pt')
            ->andWhere('p.isActive = :active')
            ->andWhere('p.status = :status')
            ->setParameter('status', $isActive)
            ->setParameter('active', $status)
        ;

        if($filterPara['dateFilter'] ?? false) {
            $now = new \DateTimeImmutable('now', new \DateTimeZone(self::TIMEZONE));
            $now = $now->format('Y-m-d H:i:s');
            $qb->andWhere(
                $qb->expr()->andX(
                    $qb->expr()->orX(
                        $qb->expr()->isNull('p.validFrom'),
                        $qb->expr()->lte('p.validFrom', '\''.$now.'\''),
                    ),
                    $qb->expr()->orX(
                        $qb->expr()->isNull('p.validTill'),
                        $qb->expr()->gte('p.validTill', '\''.$now.'\''),
                    )
                )
            );
        }

        if(!empty($filterPara['page'])) {
            $qb->andWhere('pg.code = :pgCode')
                ->setParameter('pgCode', $filterPara['page']);
            ;
        }

        if(!empty($filterPara['promoType'])) {
            $qb->andWhere('pt.code = :pgCode')
                ->setParameter('pgCode', $filterPara['page']);
            ;
        }

        $qb->orderBy('p.displayOrder', 'ASC')
            ->orderBy('p.createdAt', 'DESC')
        ;

        if(!empty($filterPara['start'])) {
            $qb->setFirstResult(intval($filterPara['start']));
        }

        if(!empty($filterPara['length'])) {
            $qb->setMaxResults(intval($filterPara['length']));
        }

        if(!empty($filterPara['select'])) {
            $qb->select($filterPara['select']);
        }
        if(!empty($filterPara['arrayResult'])) {
            return $qb->getQuery()->getArrayResult();
        }

        return  $qb->getQuery()->getResult();
    }

    //    public function findOneBySomeField($value): ?PromoBar
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
