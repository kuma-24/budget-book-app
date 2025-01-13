<?php

namespace App\Service;

use App\Entity\ExpenseTransaction;
use App\Entity\User;
use App\Repository\ExpenseTransactionRepository;

class ExpenseTransactionService
{
    private $expenseTransactionRepository;

    public function __construct(ExpenseTransactionRepository $expenseTransactionRepository)
    {
        $this->expenseTransactionRepository = $expenseTransactionRepository;
    }

    public function registerExpenseTransaction(ExpenseTransaction $expenseTransaction, User $user)
    {
        $expenseTransaction->setUser($user);

        $this->expenseTransactionRepository->save($expenseTransaction);
    }
}