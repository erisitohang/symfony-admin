<?php

namespace App\Controller;

use App\Document\Transaction;
use App\Document\User;
use App\Form\TransactionType;
use App\Service\TransactionService;
use Doctrine\ODM\MongoDB\MongoDBException;
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
     * @throws MongoDBException
     */
    public function add(Request $request): Response
    {
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Transaction $transaction */
            $transaction = $form->getData();
            $company = $this->getUser()->getCompany();
            $transaction->setCompany($company);
            $this->transactionService->createOrUpdate($transaction);

            $this->addFlash('success', 'Transaction Created!');

            return $this->redirectToRoute('app_transaction_list');
        }
        return $this->render('transactions/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/transaction/{id}", name="app_transaction_read")
     * @param $id
     * @return RedirectResponse|Response
     */

    public function read($id): Response
    {
        $company = $this->getUser()->getCompany();
        $transaction = $this->transactionService->getByIdAndCompany($id, $company);
        return $this->render('transactions/read.html.twig', array('transaction' => $transaction));
    }

    /**
     * @Route("/transaction/edit/{id}", name="app_transaction_edit")
     * @param string $id
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws MongoDBException
     */
    public function edit(string $id, Request $request): Response
    {
        $company = $this->getUser()->getCompany();
        $transaction = $this->transactionService->getByIdAndCompany($id, $company);
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Transaction $transaction */
            $transaction = $form->getData();
            $transaction->setId($id);
            $this->transactionService->createOrUpdate($transaction);
            $this->addFlash('success', 'Transaction Updated!');
            return $this->redirectToRoute('app_transaction_list');
        }
        return $this->render('transactions/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/transaction/delete/{id}", name="app_transaction_delete")
     * @param string $id
     * @return RedirectResponse|Response
     * @throws MongoDBException
     */
    public function delete(string $id): Response
    {
        $company = $this->getUser()->getCompany();
        $transaction = $this->transactionService->getByIdAndCompany($id, $company);

        $this->transactionService->delete($transaction);
        $this->addFlash('success', 'Transaction Deleted!');
        return $this->redirectToRoute('app_transaction_list');
    }
}
