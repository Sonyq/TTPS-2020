<?php

namespace App\Repository;

use App\Entity\Cama;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Cama|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cama|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cama[]    findAll()
 * @method Cama[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CamaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cama::class);
    }

    // /**
    //  * @return Cama[] Returns an array of Cama objects
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
    public function findOneBySomeField($value): ?Cama
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
