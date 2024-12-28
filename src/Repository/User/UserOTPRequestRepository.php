<?php

namespace App\Repository\User;

use App\Entity\Duct\DuctSpan;
use App\Entity\User\UserOTPRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserOTPRequest>
 *
 * @method UserOTPRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserOTPRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserOTPRequest[]    findAll()
 * @method UserOTPRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserOTPRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserOTPRequest::class);
    }

    public function deActivateAllRequests(int $appUserId = 0, string $mode = "")
    {
        $qb = $this->createQueryBuilder('p')
            ->update(UserOTPRequest::class,'p')
            ->set('p.isActive',':isA')
            ->where('IDENTITY(p.appUser) = :userId')
            ->andWhere('p.mode = :md')
            ->setParameter('isA', false)
            ->setParameter('md', $mode)
            ->setParameter('userId', $appUserId)
        ;
        return $qb->getQuery()->execute();
    }

    public function deActivateAllRequestsByMobile(string $contactNo = "", string $mode = "")
    {
        $qb = $this->createQueryBuilder('p')
            ->update(UserOTPRequest::class,'p')
            ->set('p.isActive',':isA')
            ->where('p.isActive = :iA')
            ->andWhere('p.mode = :md')
            ->andWhere('p.mobileNumber LIKE :pCt')
            ->setParameter("pCt", '%' . $contactNo . '%')
            ->setParameter('isA', false)
            ->setParameter('md', $mode)
            ->setParameter('iA', true)
        ;
        return $qb->getQuery()->execute();
    }

    function getRequestByContactNo(string $contactNo = "", array $attr = array()) : ?UserOTPRequest
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.isActive = :isA')
            ->andWhere('p.mobileNumber LIKE :pCt')
            ->setParameter("pCt", '%' . $contactNo . '%')
            ->setMaxResults(1)
            ->setParameter('isA', true);

        if(isset($attr['mode'])){
            $qb->andWhere('p.mode = :md')
                ->setParameter('md', $attr['mode']);
        }

        if(isset($attr['isActivated'])){
            $qb->andWhere('p.isActivated = :isAct')
                ->setParameter('isAct', $attr['isActivated']);
        }

        $userContact = $qb->getQuery()->getOneOrNullResult();
        return $userContact;
    }
}
