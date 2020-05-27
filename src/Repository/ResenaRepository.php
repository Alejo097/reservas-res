<?php

namespace App\Repository;

use App\Entity\Resena;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Resena|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resena|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resena[]    findAll()
 * @method Resena[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResenaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resena::class);
    }

    // /**
    //  * @return Resena[] Returns an array of Resena objects
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
    public function findOneBySomeField($value): ?Resena
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
