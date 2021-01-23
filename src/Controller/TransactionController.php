<?php

namespace App\Controller;

use App\Document\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\DocumentManager;

class TransactionController extends AbstractController
{

    /**
     * @Route("/transaction", name="app_transaction_list")
     *
     * @param DocumentManager $documentManager
     * @return Response
     */
    public function index(DocumentManager $documentManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $transactions = $user->getCompany()->getTransactions();
        return $this->render('transactions/index.html.twig', array('transactions' => $transactions));
    }
}
