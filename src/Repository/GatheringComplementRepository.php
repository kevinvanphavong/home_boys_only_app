<?php

namespace App\Repository;

use App\Entity\GatheringComplement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GatheringComplement|null find($id, $lockMode = null, $lockVersion = null)
 * @method GatheringComplement|null findOneBy(array $criteria, array $orderBy = null)
 * @method GatheringComplement[]    findAll()
 * @method GatheringComplement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GatheringComplementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GatheringComplement::class);
    }

    // /**
    //  * @return GatheringComplement[] Returns an array of GatheringComplement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GatheringComplement
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
