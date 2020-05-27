<?php

namespace App\Repository;

use App\Entity\Comentar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comentar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comentar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comentar[]    findAll()
 * @method Comentar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComentarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comentar::class);
    }

    // /**
    //  * @return Comentar[] Returns an array of Comentar objects
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
    public function findOneBySomeField($value): ?Comentar
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
