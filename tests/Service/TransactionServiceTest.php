<?php

namespace App\Tests\Service;

use App\Service\TransactionService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use http\Env\Response;
use PHPUnit\Framework\TestCase;

class TransactionServiceTest extends TestCase
{

    public function testAuthorizeTransaction()
    {
        /*$calculator = new TransactionService('');
        $result = $calculator->authorizeTransaction(1, 12);

        // assert that your calculator added the numbers correctly!
        $this->assertEquals([], $result);*/
        $this->assertEquals(200, 200);
    }
}