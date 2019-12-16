<?php

namespace App\Repository;

use App\Entity\TwoFactor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TwoFactor|null find($id, $lockMode = null, $lockVersion = null)
 * @method TwoFactor|null findOneBy(array $criteria, array $orderBy = null)
 * @method TwoFactor[]    findAll()
 * @method TwoFactor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TwoFactorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TwoFactor::class);
    }

    // /**
    //  * @return TwoFactor[] Returns an array of TwoFactor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TwoFactor
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findOneByTransactionField($transactionId, $code): ?TwoFactor
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.transaction = :transaction')
            ->andWhere('t.twoFactorCode = :code')
            ->setParameter('transaction', $transactionId)
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
