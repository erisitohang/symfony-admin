<?php

namespace App\Tests\Web\Controller;


use App\Tests\WebTestCase;

class SecurityControllerTest extends WebTestCase
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