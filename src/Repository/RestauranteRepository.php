<?php
namespace App\Repository;

use App\Entity\Restaurante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Restaurante|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurante|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurante[]    findAll()
 * @method Restaurante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestauranteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurante::class);
    }

    public function buscarRestaurante($restaurante, $ubi):array {

        $entity = $this->getEntityManager();
        $query = $entity->createQuery(
            "SELECT res  FROM App\Entity\Restaurante res
             JOIN res.ubicacion u
             WHERE UPPER(u.provincia) LIKE UPPER(:ubicacion)
             AND UPPER(res.tipo) LIKE UPPER(:tipo)
             OR
             UPPER(res.nombre) LIKE UPPER(:nombre) AND UPPER(u.provincia) LIKE UPPER(:ubicacion)
             OR 
             UPPER(res.direccion) LIKE UPPER(:direccion) AND UPPER(u.provincia) LIKE UPPER(:ubicacion)
            "
        );

        $query->setParameter("nombre", '%'.$restaurante.'%');
        $query->setParameter("tipo", '%'.$restaurante.'%');
        $query->setParameter("ubicacion", '%'.$ubi.'%');
        $query->setParameter("direccion", '%'.$restaurante.'%');
        return $query->getResult();
    }

    /*
    public function buscar($ubi):array {

        $entity = $this->getEntityManager();
        $query = $entity->createQuery(
           "SELECT res 
            FROM App\Entity\Restaurante res 
            JOIN res.ubicacion u 
            WHERE UPPER(u.provincia) LIKE UPPER(:ubicacion)
            "
        );
        
        $query->setParameter("ubicacion", '%'.$ubi.'%');
        
        return $query->getResult();
    }*/

    // /**
    //  * @return Restaurante[] Returns an array of Restaurante objects
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
    public function findOneBySomeField($value): ?Restaurante
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
