<?php

namespace App\Service;

use App\Entity\ExpenseTransaction;
use App\Entity\User;
use App\Repository\ExpenseTransactionRepository;
use DateTime;
use Symfony\Component\Form\FormInterface;

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

    public function getExpenseTransaction(int $id)
    {
        return $this->expenseTransactionRepository->find($id);
    }

    public function searchExpenseTransaction(FormInterface $form)
    {
        $year = $form->get('year')->getData();
        $month = $form->get('month')->getData();
        $expenseCategoryId = $form->get('expenseCategory')->getData();

        if (!$year) {
            $year = date('Y');
        }
        if (!$month) {
            $month = date('m');
        }

        $startDateTime = new DateTime('first day of this month');
        $endDataTime = new DateTime('last day of this month');
        $start = $startDateTime->format("{$year}-{$month}-d 00:00:00");
        $end = $endDataTime->format("{$year}-{$month}-d 23:59:59");

        return $this->expenseTransactionRepository->findByMonthAndCategory($start, $end, $expenseCategoryId);
    }

    public function aggregateExpensesByCategory($expenseTransactions)
    {
        $resultTotalePrices = [];
        $resultBudgetAmounts = [];

        foreach ($expenseTransactions as $expenseTransaction) {
            $expenseCategoryName = $expenseTransaction->getExpenseCategory()->getName();
            $expenseCategoryBudgetAmount = $expenseTransaction->getExpenseCategory()->getBudgetAmount();
            $expenseTransactionAmount = $expenseTransaction->getAmount();

            if (!array_key_exists($expenseCategoryName, $resultTotalePrices)) {
                $resultTotalePrices[$expenseCategoryName] = 0;
            }
            if (!array_key_exists($expenseCategoryName, $resultBudgetAmounts)) {
                $resultBudgetAmounts[$expenseCategoryName] = $expenseCategoryBudgetAmount;
            }

            $resultTotalePrices[$expenseCategoryName] += $expenseTransactionAmount;
        }

        return [
            'resultTotalePrices' => $resultTotalePrices,
            'resultBudgetAmounts' => $resultBudgetAmounts,
        ];
    }

    public function updateExpenseTransaction(FormInterface $form)
    {
        $expenseTransaction = $form->getData();

        $this->expenseTransactionRepository->update($expenseTransaction);
    }

    public function deleteExpenseTransaction(ExpenseTransaction $expenseTransaction)
    {
        $this->expenseTransactionRepository->remove($expenseTransaction);
    }

    public function getHeaderInfo(string $routeName, ?int $id)
    {
        $headerInfo = [
            'expense_transaction_index' => [
                'pageTitle' => '支出管理一覧',
                'headerLinks' => [
                    [
                        'name' => '新規作成',
                        'path' => 'expense_transaction_create'
                    ],
                ],
            ],
            'expense_transaction_show' => [
                'pageTitle' => '支出詳細',
                'headerLinks' => [
                    [
                        'name' => '編集',
                        'path' => 'expense_transaction_edit',
                        'id' => $id
                    ],
                ],
            ],
        ];

        return $headerInfo[$routeName];
    }

    public function getFooterInfo(string $routeName, ?int $id)
    {
        $footerInfo = [
            'expense_transaction_index' => [
                'footerLinks' => [
                    [
                        'name' => 'HOME',
                        'path' => 'dashboard_home'
                    ],
                    [
                        'name' => 'マイページ',
                        'path' => 'user_mypage_show'
                    ],
                ],
            ],
            'expense_transaction_show' => [
                'footerLinks' => [
                    [
                        'name' => 'HOME',
                        'path' => 'dashboard_home'
                    ],
                    [
                        'name' => '削除',
                        'path' => 'expense_transaction_delete',
                        'id' => $id
                    ],
                ],
            ],
        ];

        return $footerInfo[$routeName];
    }
}