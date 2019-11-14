<?php

namespace App\Repository;

use App\Entity\CurrencyInProvider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CurrencyInProvider|null find($id, $lockMode = null, $lockVersion = null)
 * @method CurrencyInProvider|null findOneBy(array $criteria, array $orderBy = null)
 * @method CurrencyInProvider[]    findAll()
 * @method CurrencyInProvider[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyInProviderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CurrencyInProvider::class);
    }

    // /**
    //  * @return CurrencyInProvider[] Returns an array of CurrencyInProvider objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CurrencyInProvider
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
