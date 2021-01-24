<?php


namespace App\Repository;


use App\Document\User;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;

class UserRepository extends ServiceDocumentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneByEmail($email)
    {
        return $this->getDocumentManager()
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);
    }

}