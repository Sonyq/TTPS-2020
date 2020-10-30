<?php

namespace App\Repository;

use App\Entity\Internacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Internacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Internacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Internacion[]    findAll()
 * @method Internacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InternacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Internacion::class);
    }

    // /**
    //  * @return Internacion[] Returns an array of Internacion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Internacion
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
