<?php

namespace App\Controller;

use App\Entity\ExpenseTransaction;
use App\Form\ExpenseTransactionCreateType;
use App\Form\ExpenseTransactionEditType;
use App\Form\ExpenseTransactionIndexSearchType;
use App\Service\ExpenseTransactionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpenseTransactionController extends AbstractController
{
    private $expenseTransactionService;

    public function __construct(ExpenseTransactionService $expenseTransactionService)
    {
        $this->expenseTransactionService = $expenseTransactionService;
    }

    public function index(Request $request): Response
    {
        $deviceType = $request->attributes->get('device');
        $routeName = $request->attributes->get('routeName');
        $headerInfo = $this->expenseTransactionService->getHeaderInfo($routeName, null);
        $footerInfo = $this->expenseTransactionService->getFooterInfo($routeName, null);

        $searchForm = $this->createForm(ExpenseTransactionIndexSearchType::class);
        $searchForm->handleRequest($request);

        $expenseTransactions = $this->expenseTransactionService->searchExpenseTransaction($searchForm);
        $aggregateExpensesByCategory = $this->expenseTransactionService->aggregateExpensesByCategory($expenseTransactions);

        $resultParameter = [
            'pageTitle' => $headerInfo['pageTitle'],
            'headerLinks' => $headerInfo['headerLinks'],
            'footerLinks' => $footerInfo['footerLinks'],
            'expenseTransactions' => $expenseTransactions,
            'aggregateExpensesByCategory' => $aggregateExpensesByCategory,
            'searchForm' => $searchForm->createView(),
        ];

        return $this->render("{$deviceType}/expense_transaction/index.html.twig", $resultParameter);
    }

    public function create(Request $request): Response
    {
        $deviceType = $request->attributes->get('device');

        $expenseTransaction = new ExpenseTransaction;
        $createForm = $this->createForm(ExpenseTransactionCreateType::class, $expenseTransaction);
        $createForm->handleRequest($request);

        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $this->expenseTransactionService->registerExpenseTransaction($expenseTransaction, $this->getUser());

            return $this->redirectToRoute('expense_transaction_index');
        }

        return $this->render("{$deviceType}/expense_transaction/create.html.twig", [
            'createForm' => $createForm->createView(),
        ]);
    }

    public function edit($id, Request $request)
    {
        $deviceType = $request->attributes->get('device');

        $expenseTransaction = $this->expenseTransactionService->getExpenseTransaction($id);

        $editForm = $this->createForm(ExpenseTransactionEditType::class, $expenseTransaction);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->expenseTransactionService->updateExpenseTransaction($editForm);

            return $this->redirectToRoute('expense_transaction_index');
        }

        return $this->render("{$deviceType}/expense_transaction/edit.html.twig", [
            'editForm' => $editForm->createView(),
        ]);
    }

    public function delete($id)
    {
        $expenseTransaction = $this->expenseTransactionService->getExpenseTransaction($id);

        if ($expenseTransaction) {
            $this->expenseTransactionService->deleteExpenseTransaction($expenseTransaction);
        }

        return $this->redirectToRoute('expense_transaction_index');
    }
}