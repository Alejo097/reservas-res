<?php

namespace App\Repository;

use App\Entity\GuardarImagen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GuardarImagen|null find($id, $lockMode = null, $lockVersion = null)
 * @method GuardarImagen|null findOneBy(array $criteria, array $orderBy = null)
 * @method GuardarImagen[]    findAll()
 * @method GuardarImagen[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GuardarImagenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GuardarImagen::class);
    }

    // /**
    //  * @return GuardarImagen[] Returns an array of GuardarImagen objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GuardarImagen
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
