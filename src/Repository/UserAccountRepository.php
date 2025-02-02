<?php

namespace App\Repository;

use App\Entity\UserAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserAccount>
 */
class UserAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAccount::class);
    }

    public function save(UserAccount $userAccount)
    {
        $this->getEntityManager()->persist($userAccount);
        $this->getEntityManager()->flush();
    }

    public function findByUserAccount($userId)
    {
        $query = $this->getEntityManager()->createQueryBuilder();

        $query
            ->select('userAccount')
            ->from('App\Entity\UserAccount', 'userAccount')
            ->where('userAccount.user = :userId')
            ->setParameter('userId', $userId)
        ;

        return $query->getQuery()->getResult();
    }
}
