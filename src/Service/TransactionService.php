<?php


namespace App\Service;


use App\Document\Company;
use App\Document\Transaction;
use App\Repository\TransactionRepository;
use Doctrine\ODM\MongoDB\MongoDBException;

class TransactionService
{
    private $repository;

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
     * @throws MongoDBException
     */
    public function createOrUpdate(Transaction $transaction): Transaction
    {
        $this->repository->getDocumentManager()->persist($transaction);
        $this->repository->getDocumentManager()->flush();

        return $transaction;
    }

    /**
     * @param string $id
     * @param Company $company
     * @return Transaction|null
     */
    public function getByIdAndCompany(string $id, Company $company): ? Transaction
    {
        return $this->repository->findOneByIdAndCompany($id, $company);
    }

    /**
     * @param Transaction $transaction
     * @return bool
     * @throws MongoDBException
     */
    public function delete(Transaction $transaction): bool
    {
        $this->repository->getDocumentManager()->remove($transaction);
        $this->repository->getDocumentManager()->flush();

        return true;
    }
}
