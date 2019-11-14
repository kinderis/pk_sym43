<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Tests\TestClient;

class TransactionControllerTest extends WebTestCase
{
    const TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1NzM3MTc0NjgsImV4cCI6MTU3MzgwMzg2OCwidXNlcm5hbWUiOiJyb290QGV4YW1wbGUuY29tIn0.trEg6bgSeOKrQWvL6uWvfZxtDmtIcb0cO0WyJ6pb0REBxJo1SqhqvsNljYfj9FygKA_TcTKX-DhU6RWKzvr9sml3ZWcM1wDuq_sHOcV2M8CtPajkEu0qTPJGc1i1k0mzrmMMYWemfpuZimT1AFIITSL8Eb_scDtqIP0FjyYw-yofroRjzrTpi1UdmDQKwU3pPeaK2jbaW_jvB_9XzBFiliuPXv7zy9Vc4UJI1BDPmpeqyAXlrbtw9clv2r_4mYXipi0MF95MroaI9iAqQoKtx3zAk8jVznea7PcmU9pUmpCsufiJrYyv8pL4xUZr5gSRQjtfZvh34YHldsG7Bd4NWoOy05BZ6soBCc2r_HxXRdVbGt93TAfOTCC8AeQAe0onDEFEtNvPRo183e6VtzpAcoH5vhh-b6yJWyO14LSOq-EF4iV-KND3EuM_IAXGzp6_-XtsV-hB0x1dtw_oilAgZlGbVnP_ikxZTOO7skmCH6T6C8i4cOFqwxdOzE6IdhkajgxH1LkPudpJfsa7GJuZ_KauQsuixWyVv1KN8t9JJb0yMtH05zTFfjZhtReHA6ZUMkXQyexYxeaJg5_FfEk-HS6XbeveQIg3NPTD8bqNfy1rfbyUhqTHnh5zU6Ur-_4dXHUdvnElp6ojyhKHBLwO1oX5vqqJtU_r5OGaumtMfG4';

    public function testCreateTransaction()
    {

        $client = new TestClient();

        $client->request('POST', '/api/createTransaction', ['headers' => ['Authorization' => 'Bearer ' . self::TOKEN]]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    public function testAuthorizeTransaction ()
    {
        $client = new TestClient();

        $client->request('POST', '/api/authorizeTransaction', ['headers' => ['Authorization' => 'Bearer ' . self::TOKEN]],[],
            ['CONTENT_TYPE' => 'application/json'], '{"code":"111"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}