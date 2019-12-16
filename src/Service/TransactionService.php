<?php

namespace App\Service;

use App\Entity\Currency;
use App\Entity\Transaction;
use App\Entity\TransactionStatus;

use App\Exception\BadRequestException;
use App\Exception\NotFoundException;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionService
{
    const DAY_AMOUNT = 100;
    const MAX_FEE = 10;
    const MIN_FEE = 5;
    const MAX_CURRENT_SUM = 1000;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function startTransaction ($user,  Request $request)
    {
        $countTransactionFee = $this->countTransactionFee($user->getId());
        $amountCnt = ($request->request->get('amount') * 100);
        $totalAmountCnt = ($amountCnt + ($amountCnt * $countTransactionFee)/100);

        $currency = $this->em->getRepository(Currency::class)->findCurrencyByName($request->request->get('currency'));

        if (null === $currency) {
            throw new NotFoundException('The specified currency does not exist');
        }
        if (false === $this->maxTotalAmount($currency, $user, $totalAmountCnt)){
            throw new BadRequestException(['The maximum total amount of possible has been exceeded'], Response::HTTP_LOCKED);
        }

        $countTransaction = $this->em->getRepository(Transaction::class)->findTractionNumberOfHoursCount($user->getId());

        if ( $countTransaction <= 10 ) {
            $now = new \DateTime();
            $transactions = new Transaction();

            $transactions->setUser($user);
            $transactions->setCurrency($currency);
            $transactions->setAmount( $amountCnt );
            $transactions->setReceiverAccount($user->getReceiverAccount());
            $transactions->setReceiverName($user->getConcatName());
            $transactions->setDetails($request->request->get('details'));
            $transactions->setTwoFactorCode( $this->createTwoFactorCode() );
            $transactions->setCreatedAt($now);
            $transactions->setUpdatedAt($now);
            $transactions->setTransactionFee( $countTransactionFee );
            $transactions->setTotalAmount( $totalAmountCnt );
            $transactions->setStatus($this->em->getRepository(TransactionStatus::class)->findOneByNameField('draft'));

            $this->em->persist($transactions);
            $this->em->flush();

            return $this->returnResult( $transactions,'The transaction started');
        } else {
            throw new BadRequestException(['The maximum number of possible transactions per hour has been exceeded'], Response::HTTP_LOCKED);
        }
    }

    private function countTransactionFee ($user_id)
    {
        $fee = self::MAX_FEE;
        $dayAmount = $this->em->getRepository(Transaction::class)->findTransactionDayAmountSum($user_id);

        if ( $dayAmount )
        {
            $fee = ($dayAmount < ((self::DAY_AMOUNT)*100)) ? $fee : self::MIN_FEE;
        }

        return $fee;
    }

    private function createTwoFactorCode ()
    {
        return '111';
    }

    private function maxTotalAmount ($currency, $user, $newTotalAmount)
    {
        $totalAmountCnt = $this->em->getRepository(Transaction::class)->findTotalAmountFromCurrency($currency, $user);
        return ((($totalAmountCnt + $newTotalAmount)/100) <= self::MAX_CURRENT_SUM) ? true : false;
    }

    private function returnResult ($result, $status)
    {
        return [
            'transaction_id' => $result->getId(),
            'details' => $result->getDetails(),
            'receiver_account' => $result->getReceiverAccount(),
            'receiver_name' => $result->getReceiverName(),
            'amount' => number_format((float)($result->getAmount()/100), 2, '.', ''),
            'currency' => $result->getCurrency()->getName(),
            'fee' => number_format((float)($result->getAmount()/100), 2, '.', ''),
            'status' => $status,
        ];
    }
}