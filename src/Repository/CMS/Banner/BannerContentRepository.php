<?php

namespace App\Repository\CMS\Banner;

use App\Entity\CMS\Banner\BannerContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BannerContent>
 */
class BannerContentRepository extends ServiceEntityRepository
{
    const TIMEZONE = 'Asia/Colombo';
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BannerContent::class);
    }

    /**
     * @param array $filterPara
     * @return BannerContent[]
     * @throws \DateMalformedStringException
     */
    public function filterBy(array $filterPara = []): array
    {
        $isActive = $filterPara['isActive'] ?? true;
        $status = $filterPara['status'] ?? true;

        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.webImage', 'wI')
            ->leftJoin('p.mobileImage', 'mI')
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

        if(!empty($filterPara['bannerGroupId'])) {
            $qb->andWhere('IDENTITY(p.bannerGroup) = :bannerGroupId')
                ->setParameter('bannerGroupId', $filterPara['bannerGroupId']);
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

    //    public function findOneBySomeField($value): ?BannerContent
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
