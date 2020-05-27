<?php

namespace App\Repository;

use App\Entity\TieneSeccion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TieneSeccion|null find($id, $lockMode = null, $lockVersion = null)
 * @method TieneSeccion|null findOneBy(array $criteria, array $orderBy = null)
 * @method TieneSeccion[]    findAll()
 * @method TieneSeccion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TieneSeccionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TieneSeccion::class);
    }

    // /**
    //  * @return TieneSeccion[] Returns an array of TieneSeccion objects
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
    public function findOneBySomeField($value): ?TieneSeccion
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
