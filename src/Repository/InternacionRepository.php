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

    public function findInternacionVigente($pacienteId)
    {
        return $this->createQueryBuilder('i')
            ->select('i.id, i.fecha_inicio_sintomas, i.fecha_diagnostico, i.fecha_carga, sist.descrip as sistema, s.nombre as sala, c.numero as cama, i.fecha_egreso, i.fecha_obito')
			->innerJoin('App:InternacionCama', 'ic', 'WITH', 'i.id = ic.internacion')
			->innerJoin('App:Cama', 'c', 'WITH', 'c.id = ic.cama')
			->innerJoin('App:Sala', 's', 'WITH', 's.id = c.sala')
			->innerJoin('App:Sistema', 'sist', 'WITH', 'sist.id = s.sistema')
            ->where('i.paciente = :pacienteId')
            ->andWhere('ic.fecha_hasta is null')
            ->andWhere('i.fecha_egreso is null')
            ->andWhere('i.fecha_obito is null')
            ->setParameter('pacienteId', $pacienteId)
            ->getQuery()
            ->getOneOrNullResult();
        ;
    }

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
