<?php

namespace App\Repository;

use App\Entity\SubirImagen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubirImagen|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubirImagen|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubirImagen[]    findAll()
 * @method SubirImagen[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubirImagenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubirImagen::class);
    }

    // /**
    //  * @return SubirImagen[] Returns an array of SubirImagen objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubirImagen
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
