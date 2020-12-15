<?php

namespace App\Repository;

use App\Entity\Sala;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Sala|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sala|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sala[]    findAll()
 * @method Sala[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sala::class);
    }

    // /**
    //  * @return Sala[] Returns an array of Sala objects
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

    
    public function findSalasBySistema($sistema_id)
    {
        return $this->createQueryBuilder('s')
            ->select('s.id, s.nombre')
            ->andWhere('s.sistema = :val')
            ->setParameter('val', $sistema_id)
            ->getQuery()
            ->getResult()
        ;
    }
    
}
