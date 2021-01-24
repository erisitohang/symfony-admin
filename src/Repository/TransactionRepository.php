<?php


namespace App\Repository;


use App\Document\Company;
use App\Document\Transaction;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;

class TransactionRepository extends ServiceDocumentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    /**
     * @param string $id
     * @param Company $company
     * @return object|null
     */
    public function findOneByIdAndCompany(string $id, Company $company): ? Transaction
    {
        return $this->getDocumentManager()
            ->getRepository(Transaction::class)
            ->findOneBy(['company' => $company, 'id' => $id]);
    }

    /**
     * @param Transaction $transaction
     * @return mixed
     */
    public function remove(Transaction $transaction)
    {
        return $this->getDocumentManager()
            ->getRepository(Transaction::class)
            ->removeTag($transaction);
    }
}
