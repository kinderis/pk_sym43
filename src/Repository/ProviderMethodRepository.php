<?php

namespace App\Repository;

use App\Entity\ProviderMethod;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProviderMethod|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProviderMethod|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProviderMethod[]    findAll()
 * @method ProviderMethod[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProviderMethodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProviderMethod::class);
    }

    // /**
    //  * @return ProviderMethod[] Returns an array of ProviderMethod objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProviderMethod
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
