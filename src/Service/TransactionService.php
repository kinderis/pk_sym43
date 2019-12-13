<?php

namespace App\Service;

use App\Entity\Currency;
use App\Entity\CurrencyInProvider;
use App\Entity\Transaction;

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

    /*
     * @throws NotFoundException
    */
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
            $start = new Transaction();

            $start->setUser($user);
            $start->setCurrency($currency);
            $start->setAmount( $amountCnt );
            $start->setReceiverAccount($user->getReceiverAccount());
            $start->setReceiverName($user->getConcatName());
            $start->setDetails($request->request->get('details'));
            $start->setTwoFactorCode( $this->createTwoFactorCode() );
            $start->setCreatedAt($now);
            $start->setUpdatedAt($now);
            $start->setTransactionFee( $countTransactionFee );
            $start->setTotalAmount( $totalAmountCnt );

            $this->em->persist($start);
            $this->em->flush();

            return $this->returnResult( $start,'The transaction started');
        } else {
            throw new BadRequestException(['The maximum number of possible transactions per hour has been exceeded'], Response::HTTP_LOCKED);
        }
    }

    public function authorizeTransaction ($user,  Request $request)
    {
        $twoAuthorize = $this->checkAuthorize($request->request->get('code'), $user);

        if ($twoAuthorize){

            $details = $twoAuthorize->getDetails();
            $currency = $twoAuthorize->getCurrency()->getId();
            $provider = $this->activateProvider ( $currency, $details );

            if (false === $provider){
                throw new NotFoundException('No supplier found');
            }

            $start = $this->em->getRepository(Transaction::class)->find($twoAuthorize->getId());

            $start->setTwoFactorCode(null);
            $start->setTransactionEnd(1);
            $start->setProviderResponse($provider);
            $start->setUpdatedAt(new \DateTime());

            $this->em->flush();
            return $this->returnResult($start,'completed');
        } else{
            throw new NotFoundException('Invalid authorization code');
        }
    }

    private function checkAuthorize ($code, $user)
    {
        $check = $this->em->getRepository(Transaction::class)->findUserAuthorizeCode($code, $user);

        return ($check) ? $check : false;
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

    private function activateProvider ($currency, $details)
    {
        $currencyInProviders = $this->em->getRepository(CurrencyInProvider::class)->findBy(['Currency' => $currency]);

        $method = [];
        foreach ( $currencyInProviders as $currencyInProvider){
            $method[] = $currencyInProvider->getProvider()->getMethod()->getMethod();
        }

        $method = $method[0];

        switch ( $method ){
            case 'substrings':
                $result = substr( $details,0,20);
                break;
            case 'appends':
                $result = $details.' '.rand();
                break;
            default:
                $result = false;
        }

        return $result;
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
            'statusCode' => Response::HTTP_OK
        ];
    }
}