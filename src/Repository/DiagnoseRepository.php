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

    // /**
    //  * @return Diagnose[] Returns an array of Diagnose objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Diagnose
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
