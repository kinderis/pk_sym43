<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    // /**
    //  * @return Transaction[] Returns an array of Transaction objects
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
    public function findOneBySomeField($value): ?Transaction
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findTractionNumberOfHoursCount ( $user_id )
    {
        $dateTime = new \DateTime();
        $subDateTime = new \DateTime();
        $subDateTime->sub(new \DateInterval('PT1H'));

        $count = $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->andWhere('t.createdAt BETWEEN \''.$subDateTime->format("Y-m-d H:i:s").'\' AND \''.$dateTime->format("Y-m-d H:i:s").'\'')
            ->andWhere('t.user = :userId')
            ->setParameter('userId', $user_id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
        return (int)$count[1];
    }

    public function findTransactionDayAmountSum ( $user_id )
    {
        $sum = $this->createQueryBuilder('t')
            ->select('sum(t.amount)')
            ->andWhere('t.createdAt <>'.date('Y'))
            ->andWhere('t.user = :userId')
            ->setParameter('userId', $user_id)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return (int)$sum[1];
    }

    public function findUserAuthorizeCode( $code, $user ): ?Transaction
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.twoFactorCode = :code')
            ->andWhere('t.user = :user')
            ->setParameter('user', $user)
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findTotalAmountFromCurrency ($currency, $user)
    {
        $count = $this->createQueryBuilder('t')
            ->select('sum(t.totalAmount)')
            ->andWhere('t.currency = :currency')
            ->andWhere('t.user = :user')
            ->setParameter('user', $user)
            ->setParameter('currency', $currency)
            ->getQuery()
            ->getOneOrNullResult()
            ;

        return(int)$count[1];
    }
}
