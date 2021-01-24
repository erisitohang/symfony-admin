<?php


namespace App\Tests;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestCase extends WebTestCase
{
    public function userLogin($client)
    {
        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        /** @var UserRepository $userRepository */
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('user@example.com');
        $client->loginUser($testUser);

        return $testUser;
    }

    public function getTransactionId($user)
    {
        $company = $user->getCompany();
        $transaction = $company->getTransactions()[0];
        return $transaction->getId();
    }
}