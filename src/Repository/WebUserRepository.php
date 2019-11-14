<?php

namespace App\Repository;

use App\Entity\WebUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WebUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebUser[]    findAll()
 * @method WebUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WebUser::class);
    }

    /**
    * @return WebUser[] Returns an array of WebUser objects
    */
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
    public function findOneBySomeField($value): ?WebUser
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
