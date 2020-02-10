<?php

namespace App\Repository;

use App\Entity\Diagnose;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Diagnose|null find($id, $lockMode = null, $lockVersion = null)
 * @method Diagnose|null findOneBy(array $criteria, array $orderBy = null)
 * @method Diagnose[]    findAll()
 * @method Diagnose[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiagnoseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Diagnose::class);
    }

    /**
     * @return Diagnose[] Retourne un tableau d'objets Diagnose
     */
    public function searchQuery($value)
    {
        return $this->createQueryBuilder('d')
            ->orWhere('d.diagnoseType LIKE :val')
            ->orWhere('d.patientName LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->orderBy('d.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return int Retourne le nombre de diagnostics stockés jusqu'ici
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function totalDiagnoses()
    {
        return $this->createQueryBuilder('d')
                    ->select('count(d.id)')
                    ->getQuery()
                    ->getSingleScalarResult()
            ;
    }

    /**
     * @return int Retourne l'âge moyen des patients
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function avgPatientAge()
    {
        return $this->createQueryBuilder('d')
            ->select('avg(d.patientAge)')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    /**
     * @return int Retourne le nombre de diagnostics sans type défini
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function nbEmptyDiagnoses()
    {
        return $this->createQueryBuilder('d')
            ->select('count(d.id)')
            ->where('d.diagnoseType IS NULL')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    /**
     * @return mixed [] Retourne le nombre de diagnostics par type
     */
    public function diagnosesByType()
    {
        return $this->createQueryBuilder('d')
            ->select('d.diagnoseType')
            ->addSelect('count(d.diagnoseType) as nbDiag')
            ->groupBy('d.diagnoseType')
            ->orderBy('nbDiag', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
