<?php

namespace App\Repository;

use App\Entity\Connection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Connection|null find($id, $lockMode = null, $lockVersion = null)
 * @method Connection|null findOneBy(array $criteria, array $orderBy = null)
 * @method Connection[]    findAll()
 * @method Connection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConnectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Connection::class);
    }

    // /**
    //  * @return Connection[] Returns an array of Connection objects
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
    public function findOneBySomeField($value): ?Connection
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
