<?php

namespace App\Repository;

use App\Entity\UserSistema;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserSistema|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSistema|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSistema[]    findAll()
 * @method UserSistema[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSistemaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserSistema::class);
    }

    // /**
    //  * @return UserSistema[] Returns an array of UserSistema objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserSistema
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
