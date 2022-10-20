<?php

namespace App\Repository;

use App\Entity\Facture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Facture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facture[]    findAll()
 * @method Facture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facture::class);
    }

    // /**
    //  * @return Facture[] Returns an array of Facture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Facture
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getNumeroDispo()
    {
        $date       = new \DateTime;
        $debutNum   = $date->format('Ym');
        $qb = $this->createQueryBuilder('f')
        ->add('select', '(f.numero)as num');
        $qb->where($qb->expr()->like('f.numero', ':numero'))
                ->setParameter('numero', '%'.$debutNum.'%')
                ->orderBy('f.numero','DESC')
                ->setMaxResults(1);
                 
        $num = $qb->getQuery()
                ->getResult();
        if(count($num)>>0)  {return $num[0]['num']+1;}
        else                {return $debutNum."01";}
         
    }
}
