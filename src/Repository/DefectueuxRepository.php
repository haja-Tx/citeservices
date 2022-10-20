<?php

namespace App\Repository;

use App\Entity\Defectueux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Defectueux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Defectueux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Defectueux[]    findAll()
 * @method Defectueux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DefectueuxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Defectueux::class);
    }

    // /**
    //  * @return Defectueux[] Returns an array of Defectueux objects
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
    public function findOneBySomeField($value): ?Defectueux
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
