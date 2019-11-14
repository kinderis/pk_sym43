<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Tests\TestClient;

class TransactionControllerTest extends WebTestCase
{
    public function testShowPost()
    {

        $client = new TestClient();

        $client->request('POST', '/api/createTransaction', ['headers' => ['Authorization' => 'Bearer ' . '']]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}