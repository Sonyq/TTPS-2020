<?php

namespace App\Repository;

use App\Entity\Evolucion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evolucion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evolucion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evolucion[]    findAll()
 * @method Evolucion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvolucionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evolucion::class);
    }

    public function findAllEvoluciones($internacionId)
    {
        return $this->createQueryBuilder('e')
        ->select('e.id, e.fecha_carga, sist.descrip as sistema')
        ->innerJoin('App:Internacion', 'i', 'WITH', 'i.id = e.internacion')
        ->innerJoin('App:Sistema', 'sist', 'WITH', 'sist.id = e.sistema_id')
        ->where('i.id = :internacionId')
        ->setParameter('internacionId', $internacionId)
        ->orderBy('e.fecha_carga', 'DESC')
        ->getQuery()
        ->getResult();
    }

}
