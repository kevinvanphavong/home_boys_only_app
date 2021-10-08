<?php

namespace App\Repository;

use App\Entity\GatheringComplementIncluded;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GatheringComplementIncluded|null find($id, $lockMode = null, $lockVersion = null)
 * @method GatheringComplementIncluded|null findOneBy(array $criteria, array $orderBy = null)
 * @method GatheringComplementIncluded[]    findAll()
 * @method GatheringComplementIncluded[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GatheringComplementIncludedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GatheringComplementIncluded::class);
    }

    // /**
    //  * @return GatheringComplementIncluded[] Returns an array of GatheringComplementIncluded objects
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
    public function findOneBySomeField($value): ?GatheringComplementIncluded
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
