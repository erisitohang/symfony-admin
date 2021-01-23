<?php


namespace App\Tests\Controller;


use App\Tests\TestCase;

class SecurityControllerTest extends TestCase
{
    public function testShowLoginPage()
    {
        $client = static::createClient();

        $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testNonAuthAccessLogout()
    {
        $client = static::createClient();

        $client->request('GET', '/logout');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}