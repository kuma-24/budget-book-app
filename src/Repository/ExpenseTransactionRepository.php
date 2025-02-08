<?php

namespace App\Repository;

use App\Entity\ExpenseCategory;
use App\Entity\ExpenseTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpenseTransaction>
 */
class ExpenseTransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpenseTransaction::class);
    }

    public function findByExpenseTransaction(ExpenseTransaction $expenseTransaction)
    {
        return $this->find($expenseTransaction->getId());
    }

    public function findByMonthAndCategory(string $startDateTime, string $endDataTime, ?ExpenseCategory $expenseCategory)
    {
        $query = $this->getEntityManager()->createQueryBuilder();

        $query
            ->select('expenseTransaction, expenseCategory, expensePaymentCategory, user')
            ->from('App\Entity\ExpenseTransaction', 'expenseTransaction')
            ->innerJoin('expenseTransaction.user', 'user')
            ->innerJoin('expenseTransaction.expenseCategory', 'expenseCategory')
            ->innerJoin('expenseTransaction.expensePaymentCategory', 'expensePaymentCategory')
            ->where('expenseTransaction.payment_date BETWEEN :start AND :end')
            ->setParameter('start', $startDateTime)
            ->setParameter('end', $endDataTime)
        ;

        if ($expenseCategory) {
            $query
                ->andWhere('expenseCategory.id = :expenseCategoryId')
                ->setParameter('expenseCategoryId', $expenseCategory->getId())
            ;
        }

        $query
            ->orderBy('expenseTransaction.payment_date', 'DESC')
        ;

        return $query->getQuery()->getResult();
    }

    public function save(ExpenseTransaction $expenseTransaction)
    {
        $this->getEntityManager()->persist($expenseTransaction);
        $this->getEntityManager()->flush();
    }

    public function update(ExpenseTransaction $expenseTransaction)
    {
        $this->getEntityManager()->persist($expenseTransaction);
        $this->getEntityManager()->flush();
    }

    public function remove(ExpenseTransaction $expenseTransaction, bool $flush = true)
    {
        $this->getEntityManager()->remove($expenseTransaction);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
