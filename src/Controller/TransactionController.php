<?php

namespace App\Controller;

use App\Document\Transaction;
use App\Document\User;
use App\Form\TransactionType;
use App\Service\TransactionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class TransactionController extends AbstractController
{
    /**
     * @var TransactionService
     */
    private $transactionService;

    /**
     * TransactionController constructor.
     * @param TransactionService $transactionService
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * @Route("/transaction", name="app_transaction_list")
     *
     * @return Response
     */
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $transactions = $user->getCompany()->getTransactions();
        return $this->render('transactions/index.html.twig', array('transactions' => $transactions));
    }

    /**
     * @Route("/transaction/add", name="app_transaction_add")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function add(Request $request): Response
    {
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $company = $this->getUser()->getCompany();
            /** @var Transaction $transaction */
            $transaction = $form->getData();
            $transaction->setCompany($company);
            $this->transactionService->create($form->getData());
            return $this->redirectToRoute('app_transaction_list');
        }
        return $this->render('transactions/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
