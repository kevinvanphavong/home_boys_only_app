<?php

namespace App\Repository;

use App\Entity\Partygoer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Partygoer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partygoer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partygoer[]    findAll()
 * @method Partygoer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartygoerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Partygoer::class);
    }

    // /**
    //  * @return Partygoer[] Returns an array of Partygoer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Partygoer
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
