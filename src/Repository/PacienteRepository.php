<?php

namespace App\Repository;

use App\Entity\Paciente;
use App\Entity\Internacion;
use App\Entity\InternacionCama;
use App\Entity\Cama;
use App\Entity\Sala;
use App\Entity\Sistema;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Paciente|null find($id, $lockMode = null, $lockVersion = null)
 * @method Paciente|null findOneBy(array $criteria, array $orderBy = null)
 * @method Paciente[]    findAll()
 * @method Paciente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PacienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paciente::class);
    }

    public function findAllPacientes($sistemaId)
    {    
        return $this->createQueryBuilder('p')
            ->select('p.dni, p.apellido, p.nombre, sist.descrip as sistema, s.nombre as sala, c.numero as cama')
            ->innerJoin('App:Internacion', 'i', 'WITH', 'i.paciente = p.id')
            ->innerJoin('App:InternacionCama', 'ic', 'WITH', 'i.id = ic.internacion')
            ->innerJoin('App:Cama', 'c', 'WITH', 'c.id = ic.cama')
            ->innerJoin('App:Sala', 's', 'WITH', 's.id = c.sala')
            ->innerJoin('App:Sistema', 'sist', 'WITH', 'sist.id = s.sistema')
            ->where('ic.fecha_hasta IS NULL')
            ->andWhere('sist.id = :sistemaId')
            ->setParameter('sistemaId', $sistemaId)
            ->orderBy('p.apellido', 'ASC')
            ->getQuery()
            ->getResult();
    }
    
}
