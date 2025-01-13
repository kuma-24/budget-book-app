<?php

namespace App\Controller;

use App\Entity\ExpenseTransaction;
use App\Form\ExpenseTransactionCreateType;
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

        return $this->render("{$deviceType}/expense_transaction/index.html.twig");
    }

    public function create(Request $request): Response
    {
        $deviceType = $request->attributes->get('device');

        $expenseTransaction = new ExpenseTransaction;
        $form = $this->createForm(ExpenseTransactionCreateType::class, $expenseTransaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->expenseTransactionService->registerExpenseTransaction($expenseTransaction, $this->getUser());

            return $this->redirectToRoute('expense_transaction_index');
        }

        return $this->render("{$deviceType}/expense_transaction/create.html.twig", [
            'form' => $form->createView(),
        ]);
    }
}