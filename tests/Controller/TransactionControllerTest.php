<?php


namespace App\Tests\Controller;


use App\Repository\UserRepository;
use App\Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    public function testNonAuthAccessTransactionsPage()
    {
        $client = static::createClient();

        $client->request('GET', '/transaction');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testVisitingWhileLoggedIn()
    {
        $client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        /** @var UserRepository $userRepository */
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('user@example.com');

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/transaction');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Transaction');
    }
}