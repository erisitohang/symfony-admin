<?php


namespace App\Tests\Controller;


use App\Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    public function testNonAuthAccessTransactionsPage()
    {
        $client = static::createClient();

        $client->request('GET', '/transaction');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}