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
        $this->userLogin($client);
        $client->request('GET', '/transaction');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Transaction');
    }

    public function testViewAddPage()
    {
        $client = static::createClient();
        $userLogin = $this->userLogin($client);
        $client->request('GET', '/transaction/add');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'New Transaction');
    }

    public function testViewReadPage()
    {
        $client = static::createClient();
        $userLogin = $this->userLogin($client);
        $transactionId = $this->getTransactionId($userLogin);
        $client->request('GET', '/transaction/' . $transactionId);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h4', 'Transaction ID: '. $transactionId);
    }

    public function testViewEditPage()
    {
        $client = static::createClient();
        $userLogin = $this->userLogin($client);
        $transactionId = $this->getTransactionId($userLogin);
        $client->request('GET', '/transaction/edit/' . $transactionId);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Edit Transaction');
    }
}