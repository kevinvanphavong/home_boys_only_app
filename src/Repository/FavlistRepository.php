<?php

namespace App\Repository;

use App\Entity\Favlist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Favlist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Favlist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Favlist[]    findAll()
 * @method Favlist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavlistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favlist::class);
    }

    // /**
    //  * @return Favlist[] Returns an array of Favlist objects
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
    public function findOneBySomeField($value): ?Favlist
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
