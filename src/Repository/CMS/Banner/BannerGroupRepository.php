<?php

namespace App\Repository\CMS\Banner;

use App\Entity\CMS\Banner\BannerGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BannerGroup>
 */
class BannerGroupRepository extends ServiceEntityRepository
{
    const TIMEZONE = 'Asia/Colombo';
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BannerGroup::class);
    }

    /**
     * @return BannerGroup[] Returns an array of BannerGroup objects
     * @throws \DateMalformedStringException
     */
    public function filterBy(array $filterPara = []): array
    {
        $isActive = $filterPara['isActive'] ?? true;
        $status = $filterPara['status'] ?? true;

        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.groupType', 'gT')
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

        if(!empty($filterPara['groupType'])) {
            $qb->andWhere('gT.code = :groupType')
                ->setParameter('groupType', $filterPara['groupType']);
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

        return  $qb->getQuery()->getResult();
    }

    //    public function findOneBySomeField($value): ?BannerGroup
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
