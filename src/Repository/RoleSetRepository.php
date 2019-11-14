<?php

namespace App\Repository;

use App\Entity\RoleSet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RoleSet|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoleSet|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoleSet[]    findAll()
 * @method RoleSet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleSetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RoleSet::class);
    }

    // /**
    //  * @return RoleSet[] Returns an array of RoleSet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RoleSet
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
