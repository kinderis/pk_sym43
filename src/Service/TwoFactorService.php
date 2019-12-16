<?php
namespace App\Service;

use App\Entity\TwoFactor;
use App\Entity\Transaction;
use App\Entity\CurrencyInProvider;

use App\Exception\NotFoundException;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class TwoFactorService
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function approveKey ($user,  Request $request)
    {
        $requestCode = $request->request->get('code');
        $transaction = $this->checkCode($requestCode, $user);

        if ($transaction) {
            $details = $transaction->getDetails();
            $currency = $transaction->getCurrency()->getId();
            $provider = $this->activateProvider($currency, $details);

            if (false === $provider){
                throw new NotFoundException('No supplier found');
            }

            $twoFactor = $this->em->getRepository(TwoFactor::class)->findOneByTransactionField($transaction->getId(), $requestCode);

            if (null === $twoFactor){
                throw new NotFoundException('No active transaction code');
            }

            $twoFactor->setReturnedCode($requestCode);
            $twoFactor->setUpdatedAt(new \DateTime());

            $transactions = $this->em->getRepository(Transaction::class)->find($transaction->getId());

            $transactions->setTwoFactorCode(null);
            $transactions->setTransactionEnd(1);
            $transactions->setProviderResponse($provider);
            $transactions->setUpdatedAt(new \DateTime());

            $this->em->flush();
            return $this->returnResult($transactions,'completed');
        }else{
            throw new NotFoundException('Invalid authorization code');
        }
    }

    private function checkCode ($code, $user)
    {
        $check = $this->em->getRepository(Transaction::class)->findUserAuthorizeCode($code, $user);

        return ($check) ? $check : false;
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
        ];
    }
}