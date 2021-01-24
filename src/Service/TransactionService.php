<?php


namespace App\Service;


use App\Document\Transaction;
use App\Repository\TransactionRepository;

class TransactionService
{
    private TransactionRepository $repository;

    /**
     * TransactionService constructor.
     * @param TransactionRepository $repository
     */
    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create new transaction
     *
     * @param Transaction $transaction
     * @return Transaction
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function create(Transaction $transaction): Transaction
    {
        $this->repository->getDocumentManager()->persist($transaction);
        $this->repository->getDocumentManager()->flush();

        return $transaction;
    }
}
